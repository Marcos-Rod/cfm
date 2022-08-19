        <footer class="fixed-bottom">
            <div class="footer py-2">
                <div class="container">
                    <div class="row text-center">
                        <a href="/aviso-de-privasidad" class="fw-bold fs-5">Aviso de privacidad</a>
                    </div>
                </div>
            </div>
        </footer>

        <script src="./libs/jquery/jquery-3.6.0.min.js"></script>
        <script src="./libs/jquery-validate/dist/jquery.validate.min.js"></script>
        <script src="./libs/jquery-validate/dist/additional-methods.min.js"></script>
        <script src="./libs/aos-master/dist/aos.js"></script>

        <?
        if (file_exists('./js/' . $url_form . '.js'))
            echo '<script src="./js/' . $url_form . '.js"></script>'
        ?>
        <script>
            AOS.init({
                easing: 'ease-in-out-sine',
                mirror: true
            });
        </script>

    </body>

</html>