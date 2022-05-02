<x-dashboard>

    <h3>Project {{ $project_details->name }}</h3>
    <hr>

    <section>
        <h4>Run all security tests</h4>
        <div id="run-all-div">
            <button class="run-all-id" id="run-all">
                <div id="loader-or-run">
                    <p>RUN ALL<br><span>May take up to 3 minutes</span></p>
                </div>
            </button>
        </div>
        <h4 style="margin-top:30px">Or run them separately</h4>
        <div id="all-tests">
            @foreach ($tests as $test)
                <div>
                    <div>
                        <button class="run-specific" test-id="{{ $test->id }}">
                            <div test-id="{{ $test->id }}" class="loader-or-run-specific" style="width:30px"><img
                                    src="/images/play-button.svg"></div>{{ $test->name }}
                        </button>
                    </div>
                    <a href="{{ '/dashboard/tests/#' . strtolower(str_replace(' ', '', $test->name)) }}"
                        class="test-link">More info</a>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <h4>Previous results</h4>

        <div id="project-history">

            @if ($project_history->count() != 0)
                @foreach ($project_history as $history)
                    @if ($history->results->count() > 0)
                        <p class="results-date">{{ $history->created_at->format('d.m.Y G:i') }}</p>
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
                                    <td>{{ $result->info }}</td>
                                    @if (!$result->vulnerable)
                                        <td>Not vulnerable</td>
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
        $("#run-all").click(function() {
            $.ajax({
                type: 'POST',
                url: '/tests/run/all',
                data: {
                    project_id: {{ $project_details->id }}
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(results) {
                    if (!results.message) {
                        let table_rows = "";
                        results.forEach(element => {
                            let fix = '';
                            if (element.vulnerable == false) {
                                fix = '<td>Not vulnerable</td>';
                            } else {
                                fix = '<td><a href="' + element.fix_link +
                                    '" target="_blank">Link</a></td>';
                            }

                            table_rows += '<tr><td>' + element.test_name + '</td><td>' + element
                                .info +
                                '</td>' + fix + '</tr><tr style="height:10px"></tr>';
                        });
                        let table = $(
                            '<p class="results-date">Now</p><table><tr><th>Test</th><th>Status</th><th>Fix</th></tr><tr style="height:15px"></tr>' +
                            table_rows + '</table>').hide().fadeIn(1000);
                        $('#project-history').prepend(table);
                        $('#no-results-yet').hide();
                    } else {
                        displayError()
                    }
                },
                error: function() {
                    displayError();
                }
            });
        });

        $(".run-specific").click(function() {
            $.ajax({
                type: 'POST',
                url: '/test/run/specific',
                data: {
                    test_id: ($(event.target).closest('button')).attr('test-id'),
                    project_id: '{{ $project_details->id }}'
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(results) {
                    if (results.test_name) {
                        let fix = '';
                        if (results.vulnerable == false) {
                            fix = '<td>Not vulnerable</td>';
                        } else {
                            fix = '<td><a href="' + results.fix_link +
                                '" target="_blank">Link</a></td>';
                        }
                        let table = $(
                            '<p class="results-date">Now</p><table><tr><th>Test</th><th>Status</th><th>Fix</th></tr><tr style="height:15px"></tr><tr><td>' +
                            results.test_name + '</td><td>' + results.info + '</td>' +
                            fix +
                            '</tr></table>').hide().fadeIn(1000);
                        $('#project-history').prepend(table);
                        $('#no-results-yet').hide();
                    } else {
                        displayError();
                    }
                },
                error: function() {
                    displayError();
                }
            });
        });

        $(document).ajaxStart(function() {
            clicked = $(event.target).closest('button');
            clicked_class = clicked.attr("class");
            if (clicked_class == "run-all-id") {
                $('#loader-or-run').html('<div class="loader"></div>');
            }
            if (clicked_class == "run-specific") {
                (clicked.find('.loader-or-run-specific')).html('<div class="loader-specific"></div>');
            }
        });

        $(document).ajaxStop(function() {
            if (clicked_class == "run-all-id") {
                $('#loader-or-run').html('<p>RUN ALL<br><span>May take up to 3 minutes</span></p>');
            }
            if (clicked_class == "run-specific") {
                (clicked.find('.loader-or-run-specific')).html('<img src="/images/play-button.svg">');
            }
        });

        function displayError() {
            $(document.body).append(
                "<div class='status status-active'><p>Something went wrong. Didn\'t receive any reponse.</p></div>"
            );
        }
    </script>

</x-dashboard>
