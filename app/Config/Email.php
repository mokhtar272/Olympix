<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'mokhtarrida30@gmail.com';
    public string $fromName   = 'Mokhtar Rida';
    public string $protocol   = 'smtp';
    public string $SMTPHost   = 'sandbox.smtp.mailtrap.io'; // Copiez l'host Mailtrap
    public string $SMTPUser   = 'de56c7c8dabdac';   // Copiez le username Mailtrap
    public string $SMTPPass   = 'c259dc5093df85';      // Copiez le mot de passe Mailtrap
    public int $SMTPPort      = 2525;                     // Copiez le port Mailtrap
    public string $SMTPCrypto = 'tls';                       // Pas besoin de TLS/SSL pour Mailtrap
    public string $mailType   = 'html';                   // Format HTML des emails
    public string $charset    = 'UTF-8';                  // Encodage
    public string $newline    = "\r\n";   
                    // Ligne à suivre pour les emails
}
