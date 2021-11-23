<x-dashboard>

    <h3>{{ $project_details->name }} project</h3>
    <hr>

    <section>
        <h4>Run new security test</h4>
        <div id="projects">
            <a href="http://"><div><p>RUN ALL<br>Version</p></div></a>
        </div>
    </section>

    <section>
        <h4>Previous results</h4>
        
        @if ($project_history->count() != 0) 
            @foreach ($project_history as $history)
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
            @endforeach
        @else
            <p style="margin-top:30px">No previous results found. Let's run first one!</p>
        @endif
            
        
    </section>

</x-dashboard>