<x-cliente-layout>
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <a href="{{ route('cliente.encomiendas.index') }}" class="text-sm font-semibold text-[#1B6B45] hover:underline">
                &larr; Volver a mis encomiendas
            </a>
            <div class="mt-5 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#1B6B45]">Detalle de encomienda</p>
                    <h1 class="mt-2 text-2xl font-bold text-[#12241C]">ENV-{{ str_pad($encomienda->id, 6, '0', STR_PAD_LEFT) }}</h1>
                </div>
                <span class="rounded-full bg-[#F6F3E9] px-3 py-1.5 text-sm font-semibold text-[#12241C]">
                    {{ ucfirst($encomienda->estado) }}
                </span>
            </div>
        </div>

        <section class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-[#12241C]">Remitente y destinatario</h2>
            <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-[#12241C]/50">Remitente</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->nombre_remitente ?: '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Teléfono del remitente</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->remitente_telefono ?: '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Destinatario</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->destinatario_nombre }}</dd></div>
                <div><dt class="text-[#12241C]/50">Teléfono del destinatario</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->destinatario_telefono ?: '—' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-2xl border border-black/10 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-[#12241C]">Envío y pago</h2>
            <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-[#12241C]/50">Ruta</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->viaje->ruta->origen ?? '—' }} → {{ $encomienda->viaje->ruta->destino ?? '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Fecha y hora del viaje</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ optional($encomienda->viaje->fecha_viaje)->format('d/m/Y') }} · {{ substr($encomienda->viaje->hora_salida, 0, 5) }}</dd></div>
                <div><dt class="text-[#12241C]/50">Tipo</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->tipoEncomienda->nombre ?? '—' }}</dd></div>
                <div><dt class="text-[#12241C]/50">Cantidad</dt><dd class="mt-1 font-semibold text-[#12241C]">{{ $encomienda->cantidad }}</dd></div>
                <div><dt class="text-[#12241C]/50">Total a pagar</dt><dd class="mt-1 font-semibold text-[#12241C]">Bs. {{ number_format((float) $encomienda->total_pagar, 2) }}</dd></div>
            </dl>
        </section>
    </div>
</x-cliente-layout>
