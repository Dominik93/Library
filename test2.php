
 
<!DOCTYPE html>
<html
    <head>
        <title> Standardy kodowania</title>
        <script src="jquery-2.1.3.min.js" type="text/javascript"></script>
        <meta charset="utf-8">  
        <script>
         
         
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
         
        var b1 = document.getElementById('fb');
        var b2 = document.getElementById('tw');
        var b3 = document.getElementById('goo');
        var tresc = document.getElementById('tresc');
        var facebook = '<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>';
        var twitter = '<a class="twitter-share-button" href="https://twitter.com/share"> Tweet </a> <script>window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));</script';
        var google = '<script src="https://apis.google.com/js/platform.js" async defer> {lang: "pl"}</script';
        $(document).ready(function(){
            alert("ready");
            $("#fb").click(function(){
                $("#tresc").html((facebook));
 
            });
            $("#tw").click(function(){
                $("#tresc").html((twitter));
 
            });
            $("#goo").click(function(){
                $("#tresc").html((google));
            });
        });
        </script>  
    </head>
     
     
     
    <body>
           
        <button id="fb">Facebook</button><br><br>
        <button id="tw">Tweeter</button><br><br>
        <button id="goo">Google</button><br><br>
        <div id="tresc"></div>
        <div class='g-plusone' data-annotation='inline' data-width='300' data-href='https://www.facebook.com/SwierkoweRancho'></div>
 
        </body>
</html>
