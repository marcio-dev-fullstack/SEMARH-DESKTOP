<div>
    @forelse ($tasksByDate as $dateGroup => $tasks)
        <h5 class="mt-4 mb-2">{{ $dateGroup }}</h5>
        <div class="list-group">
            @foreach ($tasks as $task)
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ $task['protocol'] }}</h6>
                        <span class="badge bg-primary rounded-pill">{{ $task['status'] }}</span>
                    </div>
                    <p class="mb-1">{{ $task['description'] }}</p>
                    <small><i class="bi bi-geo-alt-fill"></i> {{ $task['location'] }}</small>
                </a>
            @endforeach
        </div>
    @empty
        <div class="card text-center p-4">
            <div class="card-body">
                <i class="bi bi-check2-circle fs-1 text-success"></i>
                <h5 class="card-title mt-2">Nenhuma tarefa pendente!</h5>
                <p class="card-text">Você está em dia com suas fiscalizações.</p>
            </div>
        </div>
    @endforelse
</div>