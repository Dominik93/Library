<?php
    echo 'includuje layou<br>';
    setStartLocation();
    function Logo(){
	echo '<a href="index.php">
                    <div id="logo" align="center">
                    </div>
		</a>';
    }
    function Canvas(){
	echo '<div id="canvas">';
            Panel();
            Content();
	echo '</div>';
    }
	
    function Menu(){
	echo '<div id="menu">
                <p>
                    <ul class="menu_poziome">
			<li><a href="index.php">Strona główna</a></li>
			<li><a href="Menu/news.php">Aktualności</a></li>
			<li><a href="Menu/search.php">Szukaj pozycji</a></li>
                        <li><a href="Menu/opening_hours.php">Godziny otwarcia</a></li>
			<li><a href="Menu/regulations.php">Regulamin</a></li>
			<li><a href="Menu/contact.php">Kontakt</a></li>
			<li><a href="Menu/help.php">Pomoc</a></li>
                    </ul>
		</p>
            </div>';
    }
	
    function Panel(){
	$user = unserialize($_SESSION['user']);
	echo '<div id="panel">'.$user->showOptionPanel().'</div>';
    }
?>