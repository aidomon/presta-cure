<x-dashboard>

    <h3>Project {{ $project_details->name }}</h3>
    <hr>

    <section>
        <h4>Run new security test</h4>
        <div id="run-all-div">
            <button id="run-all"><div id="loader-or-run"><p>RUN ALL</p></div></button>
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
                            <td>{{ $result->result }}</td>
                            @if($result->tests->fix_link == null) {
                                <td><a href="javascript:;">-</a></td>
                            }
                            @else
                                <td><a href="{{ $result->tests->fix_link }}">Link</a></td>
                            @endif
                        </tr>
                        @if ($history->results->count() > 1 and !$loop->last)
                            <tr style="height:10px"></tr>
                        @endif
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
                var table = $('<p class="results-date">Now</p><table><tr><th>Test</th><th>Status</th><th>Fix</th></tr><tr style="height:15px"></tr><tr><td>' + data.test_name + '</td><td>' + data.result + '</td><td><a href="' + data.fix_link + '">Link</a></td></tr></table>').hide().fadeIn(1000);
                $("#project-history").prepend(table);
                $('#no-results-yet').hide();
            });
        });

    </script>

</x-dashboard>
