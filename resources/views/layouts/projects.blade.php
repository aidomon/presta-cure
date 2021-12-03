<x-dashboard>

    <h3>Projects</h3>
    <hr>

    <section>
        <h4>Open projects</h4>
        <div id="projects">
            @foreach ($projects as $project)
                @if($project->verified == 1)
                    <a href="/dashboard/{{ $project->slug }}"><div><p>{{ $project->name }}</p></div></a>
                @endif
            @endforeach
            <div style="width:250px">
                <form action="{{ route('add-project') }}" method="post">
                    @csrf
                    <input type="text" name="new_project" placeholder="URL" required>
                    <button type="submit" id="add-new-project">Add new project</button>
                </form>
            </div>
        </div>
    </section>

    @if($not_verified_projects_count != 0)
        <section>
            <h4>Pending verifications</h4>
            <p style="margin-top:10px">Click to verify</p>
            <div id="verifications">
                @foreach ($projects as $project)
                    @if($project->verified == 0)
                        <a id="verif" href="/verify/{{ $project->slug }}" onclick="event.preventDefault(); document.getElementById('put-request-{{ $project->slug}}').submit();">
                            <div><p>{{ $project->name }}</p></div>
                            <form id="put-request-{{ $project->slug}}" action="{{ route('verify-project',[$project->slug]) }}" method="POST" style="visibility:hidden">
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

</x-dashboard>
