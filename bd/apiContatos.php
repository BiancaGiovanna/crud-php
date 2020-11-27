<?php

    function listarContatos($id){
        //Import do arquivo de Variaveis e Constantes
        require_once('../modulo/config.php');

        //Import do arquivo de função para conectar no BD
        require_once('conexaoMysql.php');

        if(!$conex = conexaoMysql())
        {
            echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
        }


        $sql = "select tblcontatos.*, tblestados.sigla
                from tblcontatos, tblestados
                where tblcontatos.idEstado = tblestados.idEstado
                and tblcontatos.statusContato = 1 ";

                if ($id > 0) {
                    $sql = $sql . " and tblcontatos.idContato = " . $id;
                }

                $sql = $sql . " order by tblcontatos.nome asc";


        $select = mysqli_query($conex, $sql);

        while($rsContatos = mysqli_fetch_assoc($select)){
            
            $dados[] = array(
                "idContatos"        => $rsContatos['idContato'],
                "nome"              => $rsContatos['nome'],
                "celular"           => $rsContatos['celular'],
                "email"             => $rsContatos['email'],
                "idEstado"          => $rsContatos['idEstado'],
                "sigla"             => $rsContatos['sigla'],
                "dataNascimento"    => $rsContatos['dataNascimento'],
                "sexo"              => $rsContatos['sexo'],
                "obs"               => $rsContatos['obs'],
                "foto"              => $rsContatos['foto'],
                "statusContato"     => $rsContatos['statusContato']
            );
        }
        if (isset($dados)) {
            $listContantatosJSON = convertJSON($dados);
        }else{
            return false;
        }

        //verifica se foi gerado um arquivo JSON
        if(isset($listContantatosJSON)){
            return $listContantatosJSON;
        }
        else{
            return false;
        }


    }

    function buscarContatos($nome){
        //Import do arquivo de Variaveis e Constantes
        require_once('../modulo/config.php');

        //Import do arquivo de função para conectar no BD
        require_once('conexaoMysql.php');

        if(!$conex = conexaoMysql())
        {
            echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
        }
        $sql=  "select tblcontatos.*, tblestados.sigla
                from tblcontatos, tblestados
                where tblcontatos.idEstado = tblestados.idEstado
                and tblcontatos.statusContato = 1 and tblcontatos.nome like '%".$nome."%' ";
                
                
        $select = mysqli_query($conex, $sql);

        while($rsContatos = mysqli_fetch_assoc($select)){
            
            $dados[] = array(
                "idContatos"        => $rsContatos['idContato'],
                "nome"              => $rsContatos['nome'],
                "celular"           => $rsContatos['celular'],
                "email"             => $rsContatos['email'],
                "idEstado"          => $rsContatos['idEstado'],
                "sigla"             => $rsContatos['sigla'],
                "dataNascimento"    => $rsContatos['dataNascimento'],
                "sexo"              => $rsContatos['sexo'],
                "obs"               => $rsContatos['obs'],
                "foto"              => $rsContatos['foto'],
                "statusContato"     => $rsContatos['statusContato']
            );
        }
        if (isset($dados)) {
            $listContantatosJSON = convertJSON($dados);
        }else{
            return false;
        }

        //verifica se foi gerado um arquivo JSON
        if(isset($listContantatosJSON)){
            return $listContantatosJSON;
        }
        else{
            return false;
        }
    }

    //converte o array de dados em um JSON
    function convertJSON($objeto){
        //força o cabecalho do arquyivos a ser a aplicação do tipo JSON
        header("content-type:application/json");
        
        //converte o array de dados em JSON
        $listJSON = json_encode($objeto);

        return $listJSON;
    }

