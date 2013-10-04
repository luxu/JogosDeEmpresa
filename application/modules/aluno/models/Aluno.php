<?php

class Aluno_Model_Aluno extends Zend_Db_Table_Abstract {

    protected $_name = 'aluno';
    protected $_referenceMap = array
        (
        'termo' => array
            (
            'columns' => 'ter_codigo',
            'refTableClass' => 'Termo_Model_Termo',
            'refColumns' => 'ter_codigo'
        ),
        'curso' => array
            (
            'columns' => 'cur_codigo',
            'refTableClass' => 'Curso_Model_Curso',
            'refColumns' => 'cur_codigo'
        )
    );

    public function busca($id) {
		/*
        $cache = Zend_Registry::get('cache');
		//busca os posts
		$posts = new Application_Model_Posts; //cria um novo objeto Posts
		//verifica se já está no cache o resultado
		if(!$result = $cache->load('cachePosts')) {
			//não existe no cache, processar e salvar
			$result = $posts->fetchAll();//pega todos os posts
			$cache->save($result, 'cachePosts');
		}
		$this->view->data = $result;
		*/
		
		$db = Zend_Db_Table::getDefaultAdapter(); // pega uma instancia do Banco de Dados
        $row = $db->fetchRow('select * from aluno where alu_codigo = ?', $id);
        if (null !== $row)
            return $row; //->toArray();
    }
}

