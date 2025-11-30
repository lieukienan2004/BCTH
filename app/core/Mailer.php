<?php
/**
 * Simple SMTP Mailer using PHPMailer-like approach
 * Gửi email qua Gmail SMTP
 */
class Mailer {
    private $smtpHost = 'smtp.gmail.com';
    private $smtpPort = 587;
    private $smtpUser = ''; // Gmail của bạn
    private $smtpPass = ''; // App Password (không phải mật khẩu Gmail)
    private $fromEmail = '';
    private $fromName = 'TVU System';
    
    public function __construct($email = '', $password = '') {
        if ($email && $password) {
            $this->smtpUser = $email;
            $this->smtpPass = $password;
            $this->fromEmail = $email;
        }
    }
    
    public function send($to, $subject, $htmlBody) {
        // Nếu chưa cấu hình SMTP, return false
        if (empty($this->smtpUser) || empty($this->smtpPass)) {
            return false;
        }
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . $this->fromName . ' <' . $this->fromEmail . '>',
            'Reply-To: ' . $this->fromEmail,
            'X-Mailer: PHP/' . phpversion()
        ];
        
        return @mail($to, $subject, $htmlBody, implode("\r\n", $headers));
    }
    
    /**
     * Gửi email qua SMTP (sử dụng socket)
     */
    public function sendSMTP($to, $subject, $htmlBody) {
        if (empty($this->smtpUser) || empty($this->smtpPass)) {
            return ['success' => false, 'message' => 'Chưa cấu hình SMTP'];
        }
        
        try {
            $socket = @fsockopen('tls://' . $this->smtpHost, 465, $errno, $errstr, 30);
            
            if (!$socket) {
                // Thử port 587
                $socket = @fsockopen($this->smtpHost, $this->smtpPort, $errno, $errstr, 30);
                if (!$socket) {
                    return ['success' => false, 'message' => "Không thể kết nối SMTP: $errstr"];
                }
            }
            
            // SMTP conversation
            $this->getResponse($socket);
            
            fputs($socket, "EHLO localhost\r\n");
            $this->getResponse($socket);
            
            fputs($socket, "STARTTLS\r\n");
            $this->getResponse($socket);
            
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            
            fputs($socket, "EHLO localhost\r\n");
            $this->getResponse($socket);
            
            fputs($socket, "AUTH LOGIN\r\n");
            $this->getResponse($socket);
            
            fputs($socket, base64_encode($this->smtpUser) . "\r\n");
            $this->getResponse($socket);
            
            fputs($socket, base64_encode($this->smtpPass) . "\r\n");
            $this->getResponse($socket);
            
            fputs($socket, "MAIL FROM:<{$this->smtpUser}>\r\n");
            $this->getResponse($socket);
            
            fputs($socket, "RCPT TO:<{$to}>\r\n");
            $this->getResponse($socket);
            
            fputs($socket, "DATA\r\n");
            $this->getResponse($socket);
            
            $message = "To: {$to}\r\n";
            $message .= "From: {$this->fromName} <{$this->smtpUser}>\r\n";
            $message .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
            $message .= "MIME-Version: 1.0\r\n";
            $message .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message .= "\r\n";
            $message .= $htmlBody;
            $message .= "\r\n.\r\n";
            
            fputs($socket, $message);
            $this->getResponse($socket);
            
            fputs($socket, "QUIT\r\n");
            fclose($socket);
            
            return ['success' => true, 'message' => 'Email đã được gửi!'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    private function getResponse($socket) {
        $response = '';
        while ($str = fgets($socket, 515)) {
            $response .= $str;
            if (substr($str, 3, 1) == ' ') break;
        }
        return $response;
    }
}
