<?php


                $sql = "SELECT id, naam, mail, verlang, code FROM mensen WHERE groep_id = ".$_SESSION['gid']." ORDER BY naam";
                $res = mysql_query($sql) or echo_mysql_error($sql);
                $ids = array();
                $info = array();
                if(mysql_num_rows($res) < 2)
                    {
                         echo 'Er moeten minstens twee mensen in een groep zitten voor je kunt lootje trekken.';
                         header('Refresh: 3; URL="login.php"');
                         einde_pagina();
                         exit();
                    }
                else
                    {
                        while($row = mysql_fetch_assoc($res))
                            {
                                $ids[] = $row['id'];
                                $info[$row['id']] = $row;
                            }
                        $names = $got = $ids;
                        
                        $himself = true;
                        $deze = true;
                        
                        while($himself == true)
                            {
                                shuffle($got);
                                foreach($names as $key => $value)
                                    {
                                        if($value == $got[$key])
                                            {
                                                $deze = true;
                                            }
                                    }
                                if($deze == true)
                                    {
                                        $himself = true;
                                    }
                                else
                                    {
                                        $himself = false;
                                    }
                                $deze = false;
                            }
                        
                        foreach($names as $key => $value)
                            {
                                if($value == $got[$key])
                                    {
                                        echo '<h1>Error!!!!!! Iemand heeft zichzelf getrokken!</h1>';
                                        exit();
                                    }
                                if($value == $_SESSION['uid'])
                                    {
                                        $self = $got[$key];
                                    }
                                $sql2 = "UPDATE mensen SET getrokken = ".$got[$key]." WHERE id = ".$value." LIMIT 1";
                                $res2 = mysql_query($sql2) or echo_mysql_error($sql2);
                                if(empty($info[$got[$key]]['verlang']))
                                    {
                                        $info[$got[$key]]['verlang'] = "Deze persoon heeft nog geen verlanglijst opgegeven.";
                                    }
                                mail($info[$value]['naam'].' <'.$info[$value]['mail'].'>', 'Lootje getrokken!', 'Hallo '.$info[$value]['naam'].',

Met lootje trekken heb je de volgende persoon getrokken:

'.$info[$got[$key]]['naam'].'

Hieronder vind je zijn/haar verlanglijst. Deze kan nog aangepast worden, mocht dat gebeuren, dan krijg je een mailtje. De verlanglijst is ook te bekijken op de website.

'."".$info[$got[$key]]['verlang']."".'

Hieronder vind je jouw inloggegevens, voor als je ze vergeten bent.

Groepsnaam: '.$_SESSION['gname'].'
Gebruikersnaam: '.$info[$value]['naam'].'
Inlogcode: '.$info[$value]['code'].'

Met vriendelijke groeten,

De lootje-trekmachine', 'From: De lootje-trekmachine <'.$config['mail'].'>');
                            }
                        $sql3 = "UPDATE groepen SET getrokken = 1 WHERE id = ".$_SESSION['gid']." LIMIT 1";
                        $res3 = mysql_query($sql3) or echo_mysql_error($sql3);
                        if($info[$self]['verlang'] == '')
                            {
                                $info[$self]['verlang'] = 'Deze persoon heeft nog geen verlanglijst opgegeven.';
                            }
                        echo 'De trekking is gebeurd! Je hebt zelf <strong>'.$info[$self]['naam'].'</strong> getrokken. Hieronder staat zijn/haar verlanglijst, als hij/zij die heeft.<br /><br />

'.nl2br(strip_tags($info[$self]['verlang'])).'<br /><br />

<a href="login.php">Terug naar het overzicht</a>';
                    }
            }
    }
else
    {
        echo 'Je moet ingelogd zijn (als beheerder) om deze pagina te kunnen bekijken.';
    }

einde_pagina();

?>