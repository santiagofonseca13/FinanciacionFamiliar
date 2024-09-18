<!DOCTYPE html>
<html lang="es">
<?php include 'src/head.php'; ?>
<body>
    <!--Cabezera-->
    <header>
        <div class="header-content">
            <div class="logo">
                <h1>Santiago Fonseca<b>Pro</b></h1>
            </div>
            <!--Menu-->
            <div class="menu" id="show-menu">
                <nav>
                    <ul>
                        <li><a href="#"> <i class="fas fa-home"></i>Inicio</a></li>
                        <li><a href="#"> <i class="fab fa-file"> </i>Ingresos</a></li>
                        <li class="menu-selected"><a href="blog.html" class="text-menu-selected"> 
                            <i class="fas fa-file-alt"></i>Gastos</a></li>
                        <li><a href="#"> <i class="fas fa-headset"></i>Presupuesto</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div id="icon-menu">
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

    <div class="container-all" id="move-content">

    <!--Portada-->

    <div class="blog-container-cover">
        <div class="container-info-cover">
            <h1>¡Todo es posible!</h1>
            <p>---s---</p>
        </div>
    </div>

    <!--Contenido-->

    <div class="container-content">
        <article><br>
            <h1>Contenido</h1>
            <p>Hola Mundo</p>
            <ul>
                <li>Inicio</li>
                <ul>
                    <li>hola</li>
                </ul>
                <li>Tema 1</li>
            </ul>
            <br><img src="img/imagen.png" alt="">
        </article>

        <div class="container-aside">	
            <aside>
                <img src="img/img6.jpg" alt="">
                <h2>Titulo del articulo</h2>
                <p>Espacio de Publiidad-- o Articulo!</p>
                <a href="#"><button>leer más</button></a>
            </aside>
        </div>
    </div>

    <!--Pie de pagina-->
    <?php include 'src/footer.php'; ?>
</div>
<script src="js/script.js"></script>
</body>
</html>