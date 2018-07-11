<?php include 'app/classes/class_calc_ip.php'; ?>
<!DOCTYPE HTML>
<html>
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css.css">

    <meta charset="UTF-8">
    
    <title>Cálculo de máscara de sub-rede IPv4</title>

</head>
<body>
    <section>
        <h1>Calcular máscara de sub-rede IPv4</h1>
    
    <form method="POST">
        <b style="color: lightseagreen">IP/CIDR</b> <small>(Ex.: 192.168.0.1/24)</small> <br>
        <input style="border:1px lightseagreen  ; line-height: 2; padding: 0 5px; width: 200px;" type="text" name="ip" value="<?php echo @$_POST['ip'];?>">
        <input style="border:1px lightseagreen; background: lightseagreen   ; color: #fff; font-weight: 700; cursor: pointer; line-height: 2; padding: 0 5px;" type="submit" value="Calcular">
    </form>
   
<?php
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! empty( $_POST['ip'] ) ) {
    $ip = new calc_ip( $_POST['ip'] );
    
    if( $ip->valida_endereco() ) {
        echo '<h2>Configurações de rede para <span style="color: darkslategray;">' . $_POST['ip'] . '</span> </h2>';
        echo "<pre class='resultado'>";
        
        echo "<b>Endereço/Rede: </b>" . $ip->endereco_completo() . '<br>';
        echo "<b>Endereço: </b>" . $ip->endereco() . '<br>';
        echo "<b>Prefixo CIDR: </b>/" . $ip->cidr() . '<br>';
        echo "<b>Máscara de sub-rede: </b>" . $ip->mascara() . '<br>';
        echo "<b>IP da Rede: </b>" . $ip->rede() . '/' . $ip->cidr() . '<br>';
        echo "<b>Broadcast da Rede: </b>" . $ip->broadcast() . '<br>';
        echo "<b>Primeiro Host: </b>" . $ip->primeiro_host() . '<br>';
        echo "<b>Último Host: </b>" . $ip->ultimo_ip() . '<br>';
        echo "<b>Total de IPs:  </b>" . $ip->total_ips() . '<br>';
        echo "<b>Hosts: </b>" . $ip->ips_rede();
        echo "</pre>";
    } else {
        echo 'ENDEREÇO IPv4 INVÁLIDO!';
    }
}
?>
   </section>

</body>
</html>

