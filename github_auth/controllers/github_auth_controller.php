<?php
class GithubAuthController extends AppController
{
    public function signin()
    {
        $this->redirect(GithubAuth::getAuthUrl());
    }

    public function callback()
    {
        $code = Param::get('code');
        try {
            $result = GithubAuth::verify($code);
        } catch (AuthDeniedException $e) {
            $this->redirect('/');
            return;
        } catch (PermissionDeniedException $e) {
            $this->render('error/permission');
            return;
        }

        // identity は hoge@example.com が入っている
        $_SESSION['account'] = $result['identity'];

        $this->redirect('/');
    }

    public function signout()
    {
        $_SESSION = array();
        setcookie(session_name(), '', 0);
        session_destroy();

        $this->redirect('/');
    }
}
