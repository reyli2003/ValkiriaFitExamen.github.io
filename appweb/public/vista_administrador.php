<?php
session_start();
if (isset($_SESSION['usuario'])) {


    $PageTitle = "Administrador";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/navegacion_administrador.html';
    ?>

    <main>

        <div class="text-center my-5">
        </div>

        <div class="px-4 text-secondary">
            <h5 class="display-6 mb-5">Compromiso de nuestra empresa</h5>

            <ul class="fs-5">
                <li>
                    <strong>Fomentar el bienestar integral de nuestros alumnos:</strong> Nos comprometemos a promover no solo la actividad física, sino también el bienestar emocional y social de nuestros participantes, creando un ambiente positivo y motivador.
                </li>
                <li>
                    <strong>Promover un ambiente inclusivo y diverso:</strong> Valoramos la diversidad y nos aseguramos de que todas las personas, independientemente de su edad, género o nivel de habilidad, se sientan bienvenidas y cómodas en nuestras clases.
                </li>
                <li>
                    <strong>Capacitar a nuestros instructores:</strong> Ofrecemos formación continua a nuestros maestros en las últimas tendencias y técnicas en fitness y baile, garantizando que brinden una enseñanza de alta calidad y segura.
                </li>
                <li>
                    <strong>Fomentar la comunidad:</strong> Organizaremos eventos sociales y actividades grupales que permitan a nuestros alumnos interactuar y crear lazos, fortaleciendo así el sentido de comunidad dentro del local.
                </li>
                <li>
                    <strong>Promover hábitos saludables:</strong> Ofreceremos talleres sobre nutrición y estilo de vida saludable, ayudando a nuestros alumnos a complementar su actividad física con buenos hábitos alimenticios.
                </li>
                <li>
                    <strong>Cuidar el medio ambiente:</strong> Implementaremos prácticas sostenibles en nuestras instalaciones, como el uso de materiales reciclables y la reducción del consumo energético, para contribuir al cuidado del planeta.
                </li>
                <li>
                    <strong>Incorporar tecnología en nuestras clases:</strong> Utilizaremos herramientas tecnológicas para mejorar la experiencia de aprendizaje, como aplicaciones para seguimiento del progreso físico y sesiones virtuales cuando sea necesario.
                </li>
                <li>
                    <strong>Fomentar el respeto y la diversión:</strong> Promoveremos un ambiente donde el respeto mutuo y la diversión sean fundamentales, asegurando que cada clase sea una experiencia agradable para todos los participantes.
                </li>
            </ul>
    </main>

    <?php

    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}