<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\BookmarksTable $Bookmarks
 *
 * @method \App\Model\Entity\Bookmark[] paginate($object = null, array $settings = [])
 */
class BookmarksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /** Tag Fonksiyonum Özel aramaları gerçekleştirmek için yapıyorum */
    public function tags()
    {
     $tags = $this->request->getParam('pass');
     $bookmarks = $this->Bookmarks->find('tagged',[
         'tags' => $tags
     ]);
     $this->set([
         'bookmarks' => $bookmarks,
         'tags' => $tags
     ]);

    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => ['Bookmarks.user_id' => $this->Auth->user('id')]
        ];
        $this->set('bookmarks', $this->paginate($this->Bookmarks));
        $this->set('_serialize', ['bookmarks']);
    }

    /**
     * View method
     *
     * @param string|null $id Bookmark id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookmark = $this->Bookmarks->get($id, [
            'contain' => ['Users', 'Tags']
        ]);

        $this->set('bookmark', $bookmark);
        $this->set('_serialize', ['bookmark']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookmark = $this->Bookmarks->newEntity();
        if ($this->request->is('post')){
            $bookmark = $this->Bookmarks->patchEntity($bookmark,$this->request->getData());
            $bookmark->user_id = $this->Auth->user('id');
            if ($this->Bookmarks->save($bookmark)){
                $this->Flash->success(__('Kullanıcı Başarıyla Oluşturuldu'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('Kullanıcı Oluşturulurken Hata Oluştu'));
        }
        $tags = $this->Bookmarks->Tags->find('list');
        $this->set(compact('bookmark','tags'));
        $this->set('_serialize',['bookmark']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookmark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
      $bookmark = $this->Bookmarks->get($id,['contain'=>['Tags']]);
      if ($this->request->is(  ['post','put','patch'])){
          $bookmark = $this->Bookmarks->patchEntity($bookmark,$this->request->getData());
          $bookmark->user_id = $this->Auth->user('id');
          if ($this->Bookmarks->save($bookmark)){
              $this->Flash->success(__('Başarıyla Editleme Yapıldı'));
              return $this->redirect(['action'=>'index']);
          }
            $this->Flash->error(__('Konu Editlenemedi'));
      }
      $tags = $this->Bookmarks->Tags->find('Tags');
      $this->set(compact('bookmark','tags'));
      $this->set('_serialize',['bookmark']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bookmark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookmark = $this->Bookmarks->get($id);
        if ($this->Bookmarks->delete($bookmark)) {
            $this->Flash->success(__('The bookmark has been deleted.'));
        } else {
            $this->Flash->error(__('The bookmark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        if (in_array($action,['index','add','tags'])){
            return true;
        }
        if (!$this->request->getParam('pass.0')){
            return false;
        }

        $id = $this->request->getParam('pass.0');
        $bookmark = $this->Bookmarks->get($id);
        if ($bookmark->user_id == $user['id']){
            return true;
        }
        return parent::isAuthorized($user);
    }
}
