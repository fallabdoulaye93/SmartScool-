<?php
require_once("../../config/Connexion.php");

function gettoken()
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.orange.com/oauth/v2/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "Authorization:Basic ckFuR1kxZVk3ZzU2RFoydGtGOEdOOUM4SE1WZzI2Tkc6R204c21BckRueWVVSnV1Nw=="
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if($err)
    {
        return json_encode(array('error'=>1, 'message'=>$err));
    }
    else
    {
        return $response;
    }
}


 function tokenSMSOrange()
 {
     $connection =  new Connexion();
     $dbh = $connection->Connection();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.orange.com/oauth/v2/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_POST, 1);
    $headers = array();
    $headers[] = "Authorization:Basic ckFuR1kxZVk3ZzU2RFoydGtGOEdOOUM4SE1WZzI2Tkc6R204c21BckRueWVVSnV1Nw==";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if(curl_errno($ch))
    {
        echo 'Error:' . curl_error($ch);
    }
    else
    {
        $messages = '';
        $res = 0;
        $json = json_decode($result);
        if(array_key_exists('token_type', $json) && array_key_exists('access_token', $json) && array_key_exists('expires_in', $json))
        {
            $date_debut = date('Y-m-d H:i:s');
            $date_fin = date('Y-m-d', strtotime(date($date_debut)) + (int)$json->{'expires_in'});
            try
            {
                $query_rq_service = "UPDATE operateur SET token = :token, date_fin = :expire WHERE rowid = 1";
                $service = $dbh->prepare($query_rq_service);
                $service->bindParam('token', $json->{'access_token'});
                $service->bindParam('expire', $date_fin);
                $service->execute();
                if($service->rowCount() === 1)
                    $res = 1;
            }
            catch (PDOException $e)
            {
                $messages .= $e;
            }
        }
        if($res === 0){
            $messages .= "<br/>La regénération du token a échoué.<br/>Le token current expire dans moins de trois(3) jours.";
            @alerteSMS('ibrahima.fall@samaecole.com', 'Madiop GUEYE', $messages);
        }
    }
    curl_close($ch);

}

 function sendSMS($sender, $destinataire, $message)
 {
     $connection =  new Connexion();
     $dbh = $connection->Connection();
    if($destinataire[0] == '+')
    {
        $destinataire = substr($destinataire, 1);
    }
    else if($destinataire[0] == '0' && $destinataire[1] == '0')
    {
        $destinataire = substr($destinataire, 2);
    }
    $operateur = substr($destinataire, 3, 2);

    try {

        $destinataire = str_replace(' ', '', $destinataire);
        $query_rq_service = "SELECT * FROM operateur WHERE statut=1";
        $service = $dbh->prepare($query_rq_service);
        $service->execute();
        $row_rq_service = $service->fetchObject();

        $to_day = date('Y-m-d');
        $expire = date('Y-m-d', strtotime($to_day . ' + 3 days'));
        if($expire >= $row_rq_service->date_fin)
        {
            tokenSMSOrange();
        }
        if((int)$row_rq_service->rowid === 1)
        {
            $destinataire = '+' . $destinataire;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B221000000000/requests',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"outboundSMSMessageRequest":{"address":"tel:' . $destinataire . '","outboundSMSTextMessage":{"message":"' . $message . '"},"senderAddress":"tel:+221000000000","senderName":"' . $sender . '"}}',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'authorization: Bearer ' . $row_rq_service->token,
                    'content-type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if($err)
            {
                $messages = "CEMAD<br/>Erreur WS Envoi SMS Orange: " . $err . "</b>.<br/>Tel: ".$destinataire."<br/>Merci de faire le necessairee (Urgence).";
                @alerteSMS('ibrahima.fall@samaecole.com', 'Ibrahima FALL', $messages);
                return -1;
            }
            else
            {
                $json = json_decode($response);
                if(!array_key_exists('outboundSMSMessageRequest', $json) && array_key_exists('code', $json) && (int)$json->code === 42)
                {
                    @tokenSMSOrange();
                    return -1;
                }
                else if (!array_key_exists('outboundSMSMessageRequest', $json) && array_key_exists('code', $json) && (int)$json->code === 41)
                {
                    $messages = "CEMAD<br/>Le nombre de SMS restant dans le compte est arrive a epuisement.: <b>0 sms</b>.<br/>Merci de recharger le compte (Urgence).";
                    @alerteSMS('ibrahima.fall@samaecole.com', 'Ibrahima FALL 2', $messages);
                    return -1;
                }
                else if (!array_key_exists('outboundSMSMessageRequest', $json))
                {
                    $messages = "CEMAD<br/>Erreur WS Envoi SMS Orange: " . json_encode($json) . "</b>.<br/>Tel: ".$destinataire."<br/>Merci de faire le necessairee (Urgence).";
                    @alerteSMS('ibrahima.fall@samaecole.com', 'Ibrahima FALL 1', $messages);
                    return -1;
                }
                else
                {
                    $nb_sms_restant = soldeSMSOrange($row_rq_service->token);
                    if(($nb_sms_restant <= 500 && $nb_sms_restant % 10 === 0) || $nb_sms_restant <= 100)
                    {
                        $messages = "CEMAD<br/>Le nombre de SMS restant dans le compte est faible: <b>" . $nb_sms_restant . " sms</b>.<br/>Merci de recharger le compte (Urgence).";
                        @alerteSMS('ibrahima.fall@samaecole.com', 'Ibrahima FALL NUMH', $messages);
                    }
                    return 1;
                }
            }
        }
        else {
            return -1;
        }
    }
    catch (Exception $e) {
        return $e;
    }

}

 function alerteSMS($destinataire, $vers_nom, $messages) {

    $sujet = "SunuEcole CEMAD"; //Sujet du mail
    $vers_mail = $destinataire;
    $message = "<table width='550px' border='0'>";
    $message.= "<tr>";
    $message.= "<td> Cher ".$vers_nom.", </td>";
    $message.= "</tr>";
    $message.= "<tr>";
    $message.= "<td align='left' valign='top'><p>".$messages."</p></td>";
    $message.= "</tr>";
    $message.= "<tr>";
    $message.= "<td align='left' valign='top'>Merci de faire le necessaire.</td>";
    $message.= "</tr>";

    $message.= "</table>";

    $entete = "Content-type: text/html; charset=utf8\r\n";
    $entete .= "To: $vers_nom <$vers_mail> \r\n";
    $entete .= "From:CEMAD <no-reply@cemad-admin.com>\r\n";
    mail($vers_mail, $sujet, $message, $entete);
}

function soldeSMSOrange($token)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.orange.com/sms/admin/v1/contracts",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer ".$token,
            "content-type: application/json"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return $err;
    }
    else
    {
        $json = json_decode($response);
        $sms = $json->{'partnerContracts'}->{'contracts'}[0]->{'serviceContracts'}[0]->{'availableUnits'};
        return $sms;
    }
}



//echo sendSMS('CEMAD', '00221774119645','Test CEMAD');
//echo sendSMS('CEMAD', '221774119645','Test 2 CEMAD');
//echo sendSMS('CEMAD', '+221774119645','Test 3 CEMAD');
echo sendSMS('CEMAD', '221774119645','Test 4 CEMAD');
?>
