<x-cliente-layout>
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <a href="{{ route('cliente.boletos.index') }}" class="text-sm font-semibold text-[#1B6B45] hover:underline">
                &larr; Volver a mis boletos
            </a>
            <div class="mt-5 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#1B6B45]">Boleto de viaje</p>
                    <h1 class="mt-2 text-2xl font-bold text-[#12241C]">BOL-{{ str_pad($boleto->id, 6, '0', STR_PAD_LEFT) }}</h1>
                </div>
                <span class="rounded-full bg-[#F6F3E9] px-3 py-1.5 text-sm font-semibold text-[#12241C]">
                    {{ ucfirst($boleto->estado) }}
                </span>
            </div>
        </div>

        <section class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-[#12241C]">Datos del pasajero</h2>
            <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-[#12241C]/50">Pasajero</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->nombre_pasajero }}</dd></div>
                <div><dt class="text-[#12241C]/50">Documento</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->ci_pasajero ?: '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Teléfono</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->telefono_pasajero ?: '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Asiento</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->numero_asiento }}</dd></div>
            </dl>
        </section>

        <section class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-[#12241C]">Datos del viaje</h2>
            <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-[#12241C]/50">Ruta</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->viaje->ruta->origen ?? '—' }} → {{ $boleto->viaje->ruta->destino ?? '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Fecha y hora</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ optional($boleto->viaje->fecha_viaje)->format('d/m/Y') }} · {{ substr($boleto->viaje->hora_salida, 0, 5) }}</dd></div>
                <div><dt class="text-[#12241C]/50">Bus</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->viaje->bus->placa ?? '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Precio</dt><dd class="mt-1 font-semibold text-[#12241C]">Bs. {{ number_format((float) $boleto->precio, 2) }}</dd></div>
                <div><dt class="text-[#12241C]/50">Método de pago</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->metodo_pago }}</dd></div>
                @if($boleto->estado === 'pendiente' && $boleto->expira_en)
                    <div><dt class="text-[#12241C]/50">Vence</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $boleto->expira_en->format('d/m/Y H:i') }}</dd></div>
                @endif
            </dl>
        </section>
    </div>
</x-cliente-layout>
