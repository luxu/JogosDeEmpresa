<?php

/**
 * Formatação de Telefones
 * Auxiliar da Camada de Visualização
 * @author Wanderson Henrique Camargo Rosa
 * @see    APPLICATION_PATH/views/helpers/PhoneNumber.php
 */
class Zend_View_Helper_PhoneNumber extends Zend_View_Helper_Abstract
{
    /**
     * Valor Inicial de Captura
     * @var string
     */
    protected $_capture = '/^([0-9]{2})([0-9]{4})([0-9]{4})$/';

    /**
     * Valor Inicial para Formato de Saída
     * @var string
     */
    protected $_format = '($1) $2-$3';

    /**
     * Método Principal
     * @param string $value Valor para Formatação
     * @return string Valor Formatado
     */
    public function phoneNumber($value = null)
    {
        /* Acesso Direto ao Auxiliar */
        if ($value === null) {
            return $this;
        }
        /* Acesso aos Dados de Filtragem */
        $format  = $this->getFormat();
        $capture = $this->getCapture();
        /* Resultado da Renderização */
        $result = @preg_replace($capture, $format, $value);
        if ($result === null) {
            throw new Zend_View_Exception("Invalid PhoneNumber Capture: '$capture'");
        }
        return $result;
    }

    /**
     * Configura a Formatação de Saída
     * @param string Formato para Renderização do Conteúdo
     * @return Zend_View_Helper_PhoneNumber Próprio Objeto para Encadeamento
     */
    public function setFormat($format)
    {
        $this->_format = $format;
        return $this;
    }

    /**
     * Informa a Formatação de Saída
     * @return string Valor Solicitado
     */
    public function getFormat()
    {
        return $this->_format;
    }

    /**
     * Configura o Padrão de Captura
     * @param string $capture Padrão para Captura de Conteúdo
     * @return Zend_View_Helper_PhoneNumber Próprio Objeto para Encadeamento
     */
    public function setCapture($capture)
    {
        $this->_capture = $capture;
        return $this;
    }

    /**
     * Informa o Padrão de Captura
     * @return string Valor Solicitado
     */
    public function getCapture()
    {
        return $this->_capture;
    }
}