<!DOCTYPE html> 
<html lang="pt-BR"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial scale=1.0"> 
    <title>Gerenciador de Tarefas</title> 
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet"> 
</head> 
<body class="bg-light"> 
 
    <div class="container py-5" style="max-width: 800px;"> 
        <header class="pb-3 mb-4 border-bottom"> 
            <h1 class="fs-4 fw-bold text-dark"> 
                <i class="bi bi-check2-square text-primary me-2"></i>Minhas Tarefas 
            </h1> 
        </header> 
 
        <!-- Exibição de Mensagens de Sucesso --> 
        @if(session('success')) 
            <div class="alert alert-success alert-dismissible fade show" role="alert"> 
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
            </div> 
        @endif 
 
        <!-- Form de Cadastro de Nova Tarefa --> 
        <div class="card shadow-sm mb-4 border-0"> 
            <div class="card-body p-4"> 
                <h5 class="card-title mb-3">Nova Tarefa</h5> 
                <form action="{{ route('tasks.store') }}"  method="POST"> 
                    @csrf 
                    <div class="mb-3"> 
                        <label for="title" class="form-label font-weight-bold">Título <span class="text-danger">*</span></label> 
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" 
                        value="{{ old('title') }}" placeholder="Ex: Estudar Laravel 
                        Eloquent"> 
                        @error('title') 
                            <div class="invalid-feedback">{{ 
                                $message }}</div> 
                        @enderror 
                    </div> 
 
                    <div class="mb-3"> 
                        <label for="description" class="form
                        label">Descrição / Observações</label> 
                        <textarea class="form-control 
                        @error('description') is-invalid @enderror" id="description" 
                        name="description" rows="2" placeholder="Detalhes opcionais sobre a 
                        tarefa...">{{ old('description') }}</textarea> 
                        @error('description') 
                            <div class="invalid-feedback">{{ 
                                $message }}</div> 
                        @enderror 
                    </div> 
 
                    <button type="submit" class="btn btn-primary px-4"> 
                        <i class="bi bi-plus-lg me-1"></i> Adicionar 
                        Tarefa 
                    </button> 
                </form> 
            </div> 
        </div> 
 
        <div class="row g-4"> 
            <!-- Coluna 1: Tarefas Pendentes --> 
            <div class="col-md-6"> 
                <div class="card border-0 shadow-sm"> 
                    <div class="card-header bg-warning bg-opacity-10 
                    border-0 py-3"> 
                        <h6 class="card-title mb-0 text-warning
                        emphasis fw-bold"> 
                            <i class="bi bi-clock me-2"></i>Pendentes  
                            <span class="badge bg-warning text-dark 
                            rounded-pill ms-2">{{ $pendingTasks->count() }}</span> 
                        </h6> 
                    </div> 
                    <ul class="list-group list-group-flush"> 
                        @forelse($pendingTasks as $task) 
                            <li class="list-group-item p-3"> 
                                <div class="d-flex justify-content-between align-items-start mb-2"> 
                                    <span class="fw-semibold text-dark">{{ $task->title }}</span> 
                                    <div class="d-flex gap-1"> 
                                        <!-- Form para Concluir --> 
                                        <form action="{{ route('tasks.toggle', $task->id) }}" method="POST"> 
                                            @csrf 
                                            @method('PATCH') 
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Marcar como Concluída"> 
                                                <i class="bi bi-check-lg"></i> 
                                            </button> 
                                        </form> 
 
                                        <!-- Form para Excluir --> 
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"> 
                                            @csrf 
                                            @method('DELETE') 
                                            <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" title="Excluir Tarefa" 
                                            onclick="return confirm('Tem certeza que deseja excluir?')"> 
                                                <i class="bi bi-trash"></i> 
                                            </button> 
                                        </form> 
                                    </div> 
                                </div> 
                                @if($task->description) 
                                    <p class="text-muted small mb-0">{{ $task->description }}</p> 
                                @endif 
                            </li> 
                        @empty 
                            <li class="list-group-item p-3 text-center text-muted small"> 
                                Nenhuma tarefa pendente no momento! 
                            </li> 
                        @endforelse 
                    </ul> 
                </div> 
            </div> 
 
            <!-- Coluna 2: Tarefas Concluídas --> 
            <div class="col-md-6"> 
                <div class="card border-0 shadow-sm"> 
                    <div class="card-header bg-success bg-opacity-10 -border-0 py-3"> 
                        <h6 class="card-title mb-0 text-success-emphasis fw-bold"> 
                            <i class="bi bi-check-circle me-2"></i>Concluídas  
                            <span class="badge bg-success rounded-pill ms-2">{{ $completedTasks->count() }}</span> 
                        </h6> 
                    </div> 
                    <ul class="list-group list-group-flush"> 
                        @forelse($completedTasks as $task) 
                            <li class="list-group-item p-3 bg-light"> 
                                <div class="d-flex justify-content-between align-items-start mb-1"> 
                                    <span class="text-decoration-line-through text-muted">{{ $task->title }}</span> 
                                    <div class="d-flex gap-1"> 
                                        <!-- Form para Reabrir --> 
                                        <form action="{{ route('tasks.toggle', $task->id) }}" method="POST"> 
                                            @csrf 
                                            @method('PATCH') 
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Reabrir Tarefa"> 
                                                <i class="bi bi-arrow-counterclockwise"></i> 
                                            </button> 
                                        </form> 
 
                                        <!-- Form para Excluir --> 
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"> 
                                            @csrf 
                                            @method('DELETE') 
                                            <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" title="Excluir Tarefa" 
                                            onclick="return confirm('Tem certeza que deseja excluir?')"> 
                                                <i class="bi bi-trash"></i> 
                                            </button> 
                                        </form> 
                                    </div> 
                                </div> 
                                @if($task->description) 
                                    <p class="text-muted small mb-0 text-decoration-line-through">{{ $task->description }}</p> 
                                @endif 
                            </li> 
                        @empty 
                            <li class="list-group-item p-3 text-center text-muted small"> 
                                Nenhuma tarefa concluída ainda. 
                            </li> 
                        @endforelse 
                    </ul> 
                </div> 
            </div> 
        </div> 
    </div> 
 
    <script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"><
/script> 
</body> 
</html>