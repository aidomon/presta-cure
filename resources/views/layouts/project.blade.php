<x-dashboard>

    <h3>Project {{ $project_details->name }}</h3>
    <hr>

    <section>
        <h4>Run new security test</h4>
        <div id="run-all-div">
            <button id="run-all"><div id="loader-or-run"><p>RUN ALL</p></div></button>
            <!-- <button id="run-all"><div id="loader"></div></button> -->
        </div>
    </section>

    <section>
        <h4>Previous results</h4>

        <div id="project-history">

        @if ($project_history->count() != 0)
            @foreach ($project_history as $history)
                @if ($history->results->count() > 0)
                    <p class="results-date">{{ $history->created_at->diffForHumans() }}</p>
                    <table>
                        <tr>
                            <th>Test</th>
                            <th>Status</th>
                            <th>Fix</th>
                        </tr>
                        <tr style="height:15px"></tr>

                        @foreach ($history->results as $result)
                        <tr>
                            <td>{{ $result->tests->name }}</td>

                            @if ($result->result === 1)
                                <td>
                                    OK
                                </td>
                                <td><a style="pointer-events: none;cursor: default;">—</a></td>
                            @else
                                <td>
                                    vulnerable
                                </td>
                                <td><a href="{{ $result->tests->fix_link }}">Link</a></td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                    @endif
            @endforeach
        @else
            <p id="no-results-yet">No previous results found. Let's run first one!</p>
        @endif

        </div>
    </section>

    

    <script>
        
        $( document ).ajaxStart(function() {
            $('#loader-or-run').html('<div id="loader"></div>');
        });
        $( document ).ajaxStop(function() {
            $('#loader-or-run').html('<p>RUN ALL</p>');
        });

        $("#run-all").click(function(){
            $.get("/api/tests/run/all/{{ $project_details->id }}", function(data, status){
                
                // JSON.stringify(data).forEach(element => {
                //     new_results += element.name;
                // });
                //var new_results = data.test_id;

                var table = '<p class="results-date">Now</p><table><tr><th>Test</th><th>Status</th><th>Fix</th></tr><tr style="height:15px"></tr><tr><td>' + data.test_name + '</td><td>' + data.result + '</td><td><a href="' + data.fix_link + '">Link</a></td></tr></table>';
                $("#project-history").prepend(table.fadeIn('slow'));
                $('no-results-yet').hide();
                
            });
            // $.post("demo_test_post.asp",
            //     {
            //         name: "Donald Duck",
            //         city: "Duckburg"
            //     },
            //     function(data, status){
            //         alert("Data: " + data + "\nStatus: " + status);
            // });
        });

    </script>

</x-dashboard>
