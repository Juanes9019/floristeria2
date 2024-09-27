<h3>Historial PQRS</h3>

@if($pqrs->isEmpty())
    <p class="text-center mb-3">En este momento no tienes PQRS realizadas</p>
@else
    <div class="accordion" id="pedidosAccordion">
        @foreach($pqrs as $item)
            <div class="card mb-3">
                <div class="card-header" id="heading{{ $item->id }}">
                    <h5 class="mb-0 d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold">PQRS #{{ $loop->iteration }} - {{ $item->estado }}</span>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#pqrs-{{ $item->id }}" aria-expanded="false" aria-controls="pqrs-{{ $item->id }}">
                            <i class="fas fa-chevron-down"></i> <span class="d-none d-sm-inline">Ver Detalles</span>
                        </button>
                    </h5>
                </div>

                <div id="pqrs-{{ $item->id }}" class="collapse" aria-labelledby="heading{{ $item->id }}" data-bs-parent="#pedidosAccordion">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <strong>Usuario:</strong>
                                <p>{{ $item->user->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Fecha de Envío:</strong>
                                <p>{{ $item->fecha_envio }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Tipo:</strong>
                                <p>{{ $item->tipo }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Estado:</strong>
                                <p>{{ $item->estado }}</p>
                            </div>
                            <div class="col-md-5">
                                <strong>Motivo:</strong>
                                <p>{{ $item->motivo }}</p>
                            </div>
                            <div class="col-md-12">
                                <strong>Descripción:</strong>
                                <p>
                                    {{ Str::limit($item->descripcion, 50) }}
                                    @if(strlen($item->descripcion) > 50)
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#descripcionModal-{{ $item->id }}">
                                            Ver más
                                        </a>
                                    @endif
                                </p>
                                <button class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#respuestaModal-{{ $item->id }}">
                                    <i class="fas fa-reply"></i> {{ __('Ver respuesta') }}
                                </button>
                            </div>
                        </div>

                        <div class="modal fade" id="descripcionModal-{{ $item->id }}" tabindex="-1" aria-labelledby="descripcionModalLabel-{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="descripcionModalLabel-{{ $item->id }}">Descripción completa ingresada</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $item->descripcion }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="respuestaModal-{{ $item->id }}" tabindex="-1" aria-labelledby="respuestaModalLabel-{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="respuestaModalLabel-{{ $item->id }}">Respuesta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($item->respuesta)
                                            <p><strong>Fecha de Respuesta:</strong> {{ $item->fecha_respuesta }}</p>
                                            <p><strong>Respuesta:</strong> {{ $item->respuesta }}</p>
                                        @else
                                            <p>No hay respuesta (respuesta habilitada en 8 días)</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

