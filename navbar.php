
    <div class="container-fluid" id="mainNav">
    <nav class= "navbar navbar-inverse">
    	<div class="container">
    	<ul class= "nav navbar-nav">
    		<li <?php if ($paginaAtiva == 'paginaHome') echo "class='active' "; ?> >
    			<a href= "home.php">Página Principal</a>
    		</li>
    		<li <?php if ($paginaAtiva == 'paginaGaleria') echo "class='active' "; ?> >
    			<a href= "galeria.php">Galeria</a>
    		</li>
    		<li <?php if ($paginaAtiva == 'paginaContato') echo "class='active' "; ?> >
    			<a href= "contato.php">Contato</a>
    		</li>
    		<li <?php if ($paginaAtiva == 'paginaAgendamento') echo "class='active' "; ?> >
    			<a href= "agendamento.php">Agendamento</a>
    		</li>

    	</ul>
    	<ul class="nav navbar-nav navbar-right">
    		<li <?php if ($paginaAtiva == 'paginaAcesso') echo "class='active' "; ?> >
    			<a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-user" >
            </span>&nbsp;Entrar
          </a>
    		</li>
    		<li>
    			<a href="#" class="btn btn-default">
            <span class="glyphicon glyphicon-log-in">
            </span>&nbsp;Sair
          </a>
    		</li>
    	</ul>
    	</div>
    </nav>
    </div>
