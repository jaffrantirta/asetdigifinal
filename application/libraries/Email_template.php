<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email_template {
    protected $_ci;

    public function __construct(){
        $this->_ci = &get_instance();
    }

    public function template($data){
        $pesan = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		    <head>
		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <meta name="viewport" content="width=device-width" />
		    <meta property="og:title"/>
		    <style type="text/css">
		        .ExternalClass {width:100%;}
		        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
		        body {-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; text-size-adjust:100%; margin:0; padding:0;}

		        /* Reset padding around tables */
		        table {border-spacing:0; border-collapse:collapse;}

		        /* Resolves the Outlook 2007, 2010, and Gmail padding issue. */
		        table td {border-collapse:collapse;}

		        /* Clean, responsive images. */
		        img {-ms-interpolation-mode:bicubic; display:block; outline:none; text-decoration:none;}
		        a img {border:none;}
		        p {margin:0; padding:0; margin-bottom:0;}
		        h1, h2, h3, h4, h5, h6 {color:#333333; line-height:100%;}
		        body, #body_style {width:100% !important; min-height:1000px; color:#333333; background:#e0dbcf; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; font-size:13px; line-height:1.4;}
		        a         {color:#114eb1; text-decoration:none;}
		        a:link    {color:#114eb1; text-decoration:none;}
		        a:visited {color:#183082; text-decoration:none;}
		        a:focus   {color:#0066ff !important;}
		        a:hover   {color:#0066ff !important;}
		        a[href^="tel"], a[href^="sms"] {text-decoration:none; color:#333333; pointer-events:none; cursor:default;}
		        .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:default; color:#6e5c4f !important; pointer-events:auto; cursor:default;}
		        @media only screen and (max-width: 639px) {

		            .hide {display:none !important;}

		            /* Adjust table widths at smaller screen sizes. */
		            .table {width:320px !important;}
		            .innertable {width:280px !important;}

		            /* Resize hero image at smaller screen sizes. */
		            .heroimage {width:280px !important; height:100px !important;}

		            /* Resize page shadow at smaller screen sizes. */
		            .shadow {width:280px !important; height:4px !important;}

		            /* Collapse cells at smaller screen sizes. */
		            .collapse-cell {width:320px !important;}

		            /* Range social icons left at smaller screen sizes. */
		            .social-media img {float:left !important; margin:0 1em 0 0 !important;}

		        }
		        .btn {
		  box-sizing: border-box;
		  -webkit-appearance: none;
		     -moz-appearance: none;
		          appearance: none;
		  background-color: transparent;
		  border: 2px solid #e74c3c;
		  border-radius: 0.6em;
		  color: #e74c3c;
		  cursor: pointer;
		  display: flex;
		  align-self: center;
		  font-size: 1rem;
		  font-weight: 400;
		  line-height: 1;
		  margin: 20px;
		  padding: 1.2em 2.8em;
		  text-decoration: none;
		  text-align: center;
		  text-transform: uppercase;
		  font-family: "Montserrat", sans-serif;
		  font-weight: 700;
		}
		.btn:hover, .btn:focus {
		  color: #fff;
		  outline: 0;
		}

		.first {
		  transition: box-shadow 300ms ease-in-out, color 300ms ease-in-out;
		}
		.first:hover {
		  box-shadow: 0 0 40px 40px #e74c3c inset;
		}
		    </style>
		</head>
		<body style="width:100% !important; min-height:1000px; color:#333333; background:#e0dbcf; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; font-size:13px; line-height:1.4;" alink="#114eb1" link="#114eb1" bgcolor="#e0dbcf" text="#333333">
		    <div id="body_style">
		        <table cellpadding="0" cellspacing="0" border="0" align="center" style="width:100% !important; margin:0; padding:0;">
		            <tr bgcolor="#f0f0f0">
		                <td>
		                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
		                        <tr bgcolor="#ffffff">
		                            <td style="padding-top:20px;">
		                                <table style="margin-bottom:1em;" width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="innertable">
		                                    <tr>
		                                        <td>
		                                            <table width="100%" cellpadding="10" cellspacing="0" border="0">
		                                                <tr>
		                                                    <td>
		                                                        <h1 style="color:#666666; font-size:26px; line-height:1.2; font-weight:normal; margin-top:0; margin-bottom:0.5em;">Pesan anda :</h1>
		                                                        <p style="margin-top:0; margin-bottom:0;">Nama : '.$data['name'].'  </p></br>
		                                                        <p style="margin-top:0; margin-bottom:0;">Email : '.$data['email'].'  </p></br>
                                                                <p style="margin-top:0; margin-bottom:0;">Pesan : '.$data['comment'].'  </p></br>
		                                                    </td>
		                                                </tr>
		                                            </table>
		                                        </td>
		                                    </tr>
		                                    <tr>
                                                <td>
                                                    <table width="100%" cellpadding="10" cellspacing="0" border="0">
                                                            <tr>
                                                                <td>
                                                                    <h1 style="color:#666666; font-size:26px; line-height:1.2; font-weight:normal; margin-top:0; margin-bottom:0.5em;">Balasan :</h1>
                                                                    <p style="margin-top:0; margin-bottom:0;">'.$data['message'].'</p></br>
                                                                </td>
                                                            </tr>
                                                    </table>
                                                </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            <img src="img/shadow.gif" width="560" height="8" border="0" alt="" class="shadow" />
		                                        </td>
		                                    </tr>
		                                </table>
		                            </td>
		                        </tr>
		                        <tr>
		                            <td>
		                                <table bgcolor="#cccccc" width="100%" cellpadding="0" cellspacing="0" border="0">
		                                    <tr>
		                                        <td>
		                                            <table align="left" width="280" cellpadding="10" cellspacing="0" border="0" class="collapse-cell">
		                                                <tr>
		                                                    <td>
		                                                        <a href="*|FORWARD|*" target="_blank" style="color:#114eb1; text-decoration:none;">Follow Kami di Sosial Media!</a> <span style="color:#666666;">&#124;</span> <a href="*|LIST:URL|*" target="_blank" style="color:#114eb1; text-decoration:none;">Kontak Kami</a><br />
		                                                    </td>
		                                                </tr>
		                                            </table>
		                                            <table align="right" width="280" cellpadding="10" cellspacing="0" border="0" class="collapse-cell social-media">
		                                               
		                                            </table>
		                                        </td>
		                                    </tr>
		                                </table>
		                            </td>
		                        </tr>
		                        <tr>
		                            <td>
		                                <table width="100%" cellpadding="10" cellspacing="0" border="0">
		                                    <tr>
		                                        <td valign="top" style="font-size:11px;">
		                                            &copy;2020 Sudana Bejo. All rights reserved. This email was sent to '.$data['email'].', by drivebali2016@gmail.com
		                                        </td>
		                                    </tr>
		                                        <tr>
		                                            <td valign="top" style="font-size:11px;">
		                                                Salam Hangat
		                                            </td>
		                                        </tr>
		                                </table>
		                            </td>
		                        </tr>
		                    </table>
		                </td>
		            </tr>
		        </table>
		    </div>
		</body>
		</html>';

        return $pesan;
    }
}
