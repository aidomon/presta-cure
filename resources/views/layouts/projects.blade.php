<x-dashboard>

    <h3>Projects</h3>
    <hr>

    <section>
        <h4>Open projects</h4>
        <div id="projects">
            @foreach ($projects as $project)
                @if ($project->verified == 1)
                    <a href="/dashboard/{{ $project->slug }}">
                        <div>
                            <p project-id="{{ $project->id }}">{{ $project->name }}</p>
                            <div class="delete-project">×</div>
                        </div>
                    </a>
                @endif
            @endforeach
            <div style="width:250px">
                <form action="{{ route('add-project') }}" method="post">
                    @csrf
                    <input type="url" name="new_project" placeholder="https://domain.com" required>
                    <button type="submit" id="add-new-project">Add new project</button>
                </form>
            </div>
        </div>
    </section>

    @if ($not_verified_projects_count != 0)
        <section>
            <h4>Pending verifications</h4>
            <p style="margin-top:10px">Click to verify</p>
            <div id="verifications">
                @foreach ($projects as $project)
                    @if ($project->verified == 0)
                        <a id="verif" href="/verify/{{ $project->slug }}"
                            onclick="event.preventDefault(); document.getElementById('put-request-{{ $project->slug }}').submit();">
                            <div>
                                <p>{{ $project->name }}</p>
                            </div>
                            <form id="put-request-{{ $project->slug }}"
                                action="{{ route('verify-project', [$project->id]) }}" method="POST"
                                style="visibility:hidden">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                    @endif
                @endforeach
            </div>
        </section>
    @endif

    @include('components.show-status-bar')

    <script>
        $('.delete-project').click(function(e) {
            e.preventDefault();
            var project = $(e.target).siblings('p');

            if (confirm("Are you sure you want to delete " + project.html() + " project?") == true) {
                $.ajax({
                    type: 'DELETE',
                    url: '/project/delete/' + project.attr('project-id'),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(){
                        $(e.target).closest('a').hide();
                    },
                    error: function() {
                        displayError();
                    }
                });
            }
        });

        function displayError() {
            $(document.body).append(
                "<div class='status status-active'><p>Something went wrong. Didn\'t receive any reponse.</p></div>"
            );
        }
    </script>

</x-dashboard>
