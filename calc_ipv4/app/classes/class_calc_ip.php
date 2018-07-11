<?php

class calc_ip
{
    public $endereco;
    public $cidr;
    public $endereco_completo;

    public function __construct( $endereco_completo ) {
        $this->endereco_completo = $endereco_completo;
        $this->valida_endereco();
    }

    public function valida_endereco() {

           $regexp = '/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\/[0-9]{1,2}$/';

        if ( ! preg_match( $regexp, $this->endereco_completo ) ) {
            return false;
        }
        $endereco = explode( '/', $this->endereco_completo );
        $this->cidr = (int) $endereco[1];
        $this->endereco = $endereco[0];
        if ( $this->cidr > 32 ) {
            return false;
        }
        foreach( explode( '.', $this->endereco ) as $numero ) {
            $numero = (int) $numero;
            if ( $numero > 255 || $numero < 0 ) {
                return false;
            }
        }

        return true;
    }

    public function endereco_completo() { 
        return ( $this->endereco_completo ); 
    }

    public function endereco() { 
        return ( $this->endereco ); 
    }

    public function cidr() { 
        return ( $this->cidr ); 
    }

    public function mascara() {
        if ( $this->cidr() == 0 ) {
            return '0.0.0.0';
        }

        return ( 
            long2ip(
                ip2long("255.255.255.255") << ( 32 - $this->cidr ) 
            )
        );
    }
    public function rede() {
        if ( $this->cidr() == 0 ) {
            return '0.0.0.0';
        }

        return (
            long2ip(
                ( ip2long( $this->endereco ) ) & ( ip2long( $this->mascara() ) )
            )
        );
    }
    public function broadcast() {
        if ( $this->cidr() == 0 ) {
            return '255.255.255.255';
        }
        
        return (
            long2ip( ip2long($this->rede() ) | ( ~ ( ip2long( $this->mascara() ) ) ) )
        );
    }
    public function total_ips() {
        return( pow(2, ( 32 - $this->cidr() ) ) );
    }

    public function ips_rede() {
        if ( $this->cidr() == 32 ) {
            return 0;
        } elseif ( $this->cidr() == 31 ) {
            return 0;
        }
        
        return( abs( $this->total_ips() - 2 ) );
    }
    public function primeiro_host() {
        if ( $this->cidr() == 32 ) {
            return null;
        } elseif ( $this->cidr() == 31 ) {
            return null;
        } elseif ( $this->cidr() == 0 ) {
            return '0.0.0.1';
        }
        
        return (
            long2ip( ip2long( $this->rede() ) | 1 )
        );
    }

    public function ultimo_ip() {
        if ( $this->cidr() == 32 ) {
            return null;
        } elseif ( $this->cidr() == 31 ) {
            return null;
        }
    
        return (
            long2ip( ip2long( $this->rede() ) | ( ( ~ ( ip2long( $this->mascara() ) ) ) - 1 ) )
        );
    }
}

// a função ip2long Converte uma string contendo um endereço pontilhado do Protocolo da Internet (IPv4) em um inteiro longo.