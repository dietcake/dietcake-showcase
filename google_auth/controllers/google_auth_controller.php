<?php

class GoogleAuthController extends AppController
{
    /**
     * Googleアカウントの認証画面へリダイレクトする
     */
    public function index()
    {
        $url = GoogleAuth::getAuthUrl();
        $this->redirect($url);
    }

    /**
     * 認証画面からのコールバックを処理する
     */
    public function callback()
    {
        $code = Param::get('code');
        $result = GoogleAuth::verify($code);

        // @TODO $result['identify'] と、 $result['token'] を元にユーザーを作ってください
        /*
        $user = User::create($result['identity'], $result['token']);
        Session::setId($user->id);
        */

        $url = Session::get('redirect', '/');
        Session::delete('redirect');
        $this->redirect($url);
    }
}
