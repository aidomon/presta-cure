<x-dashboard>

    <h3>Projects</h3>
    <hr>

    <section>
        <h4>Open projects</h4>
        <div id="projects">
            @foreach ($projects as $project)
                <a href="/dashboard/{{ $project->slug }}"><div><p>{{ $project->name }}</p></div></a>
            @endforeach
            <div>
                <form action="{{ route('add-project') }}" method="post">
                    @csrf
                    <input type="text" name="new_project" placeholder="Project name" required>
                    <button type="submit">Add new project</button>
                </form>
            </div>
            <!-- <a href="http://"><div id="new-project"><p style="font-size: 30px;">Add new project</p></div></a> -->
        </div>
    </section>

    <section>
        <h4>Pending verifications</h4>
        <div id="verifications">
            <a href="http://"><div><p>Blog.cz</p></div></a>
        </div>
    </section>



</x-dashboard>
