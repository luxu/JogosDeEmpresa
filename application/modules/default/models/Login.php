<?php

class Default_Model_Login {

    public static function login($login, $senha, $acesso) {
        $model = new self; // instancia a variável na msm classe
        $db = Zend_Db_Table::getDefaultAdapter();
        $adapter = new Zend_Auth_Adapter_DbTable($db);
        if ($acesso == 'Coordenador') {
            $adapter->setTableName('coordenador')
                    ->setIdentityColumn('coo_login')
                    ->setCredentialColumn('coo_senha');
            $SairCampo = 'coo_senha';
        } else {
            $adapter->setTableName('aluno')
                    ->setIdentityColumn('alu_ra')
                    ->setCredentialColumn('alu_senha');
            $SairCampo = 'alu_senha';
        }
        $select = $adapter->getDbSelect();
//        $select->where('usu_acesso = "Y"');
        $adapter->setIdentity($login);
        $adapter->setCredential($senha);
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $data = $adapter->getResultRowObject(null,$SairCampo); // traz todo os dados da tabela
            $auth->getStorage()->write($data);
            return true;
        } else {
            return $model->getMessages($result);
        }
    }

    public function getMessages(Zend_Auth_Result $result) {
        switch ($result->getCode()) {
            case $result::FAILURE_IDENTITY_NOT_FOUND:
                $msg = 'Login não encontrado';
                break;
            case $result::FAILURE_IDENTITY_AMBIGUOUS:
                $msg = 'Login em duplicidade';
                break;
            case $result::FAILURE_CREDENTIAL_INVALID:
                $msg = 'Senha não corresponde';
                break;
            default:
                $msg = 'Login/senha não encontrados';
        }
        return $msg;
    }
}