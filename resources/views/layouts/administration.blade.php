<x-dashboard>

    <h3>Admin Panel</h3>
    <hr>

    <section id="load-tests">
        <h4>Load new tests into database</h4>
        <p>If you want to load new tests after you have defined them in \App\Tests folder, press the button bellow:</p>
        <div id="run-all-div">
            <button id="run-all"><div id="loader-or-run"><p>LOAD ALL</p></div></button>
        </div>
    </section>

    <script>

        $( document ).ajaxStart(function() {
            $('#loader-or-run').html('<div id="loader"></div>');
        });

        $("#run-all").click(function(){
            $.get("/admin/load-tests", function(data, status){
                $('#loader-or-run').html('<p style="color:#16a44a">' + data.status + '</p>');
                setTimeout(function() {
                    $('#loader-or-run').html('<p>LOAD ALL</p>');
                }, 2500);
            });
        });

    </script>

</x-dashboard>
