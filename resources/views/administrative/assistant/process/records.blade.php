<div class="row">
    @empty($data)
    <div class="console">
        <i class="fal fa-sparkles text-secondary"></i>
    </div>
    @else
    <div class="col-md-4">
        <div class="box">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th colspan="2">
                            Procesos
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $process)
                    <tr id="action-process-see-{{ $process['id'] }}" class="{{ $process['status'] }}" data-route="ver/{{ $process['id'] }}" data-overlap-show="#overapp">
                        <td>
                            {{ $process['id'] }}
                            {{ $process['label'] }}
                            <strong class="progress-number">
                                {{ $process['progress'] }}%
                            </strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div id="command-output" class="console">
         <i class="fa-light fa-code-simple text-secondary"></i>
        </div>
    </div>
    @endempty
</div>