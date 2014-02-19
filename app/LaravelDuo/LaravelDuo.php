<?php namespace LaravelDuo;


class LaravelDuo extends Duo {

    private $_AKEY = 'THISISMYSUPERSECRETCUSTOMERKEYDONOTSHARE';
    private $_IKEY = 'SECRET_IKEY_FROM_DUO';
    private $_SKEY = 'SECRET_SKEY_FROM_DUO';
    private $_HOST = 'HOST_FROM_DUO';

    public function get_akey()
    {
        return $this->_AKEY;
    }

    public function get_ikey()
    {
        return $this->_IKEY;
    }

    public function get_skey()
    {
        return $this->_SKEY;
    }

    public function get_host()
    {
        return $this->_HOST;
    }

} 