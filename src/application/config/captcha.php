<?php

# KCAPTCHA configuration file

$config['alphabet'] = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!

# symbols used to draw CAPTCHA
//$config['allowed_symbols'] = "0123456789"; #digits
//$config['allowed_symbols'] = "23456789abcdegkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)
$config['allowed_symbols'] = "23456789abcdegikpqsvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)

# folder with fonts
$config['fontsdir'] = 'fonts';	

# CAPTCHA string length
$config['length'] = mt_rand(5,7); # random 5 or 6 or 7
//$config['length'] = 6;

# CAPTCHA image size (you do not need to change it, this parameters is optimal)
$config['width'] = 160;
$config['height'] = 80;

# symbol's vertical fluctuation amplitude
$config['fluctuation_amplitude'] = 8;

#noise
//$config['white_noise_density=0; // no white noise
$config['white_noise_density'] = 1/6;
//$config['black_noise_density'] = 0; // no black noise
$config['black_noise_density'] = 1/30;

# increase safety by prevention of spaces between symbols
$config['no_spaces'] = true;

# show credits
$config['show_credits'] = true; # set to false to remove credits line. Credits adds 12 pixels to image height
$config['credits'] = 'www.captcha.ru'; # if empty, HTTP_HOST will be shown

# CAPTCHA image colors (RGB, 0-255)
//$config['foreground_color'] = array(0, 0, 0);
//$config['background_color'] = array(220, 230, 255);
$config['foreground_color'] = array(mt_rand(0,80), mt_rand(0,80), mt_rand(0,80));
$config['background_color'] = array(mt_rand(220,255), mt_rand(220,255), mt_rand(220,255));

# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
$config['jpeg_quality'] = 90;
?>