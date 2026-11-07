<?php

namespace Tests\Feature;

use App\Models\Boleto;
use App\Models\Bus;
use App\Models\Cliente;
use App\Models\Encomienda;
use App\Models\Reserva;
use App\Models\Ruta;
use App\Models\TipoEncomienda;
use App\Models\Viaje;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteRecordsTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_can_view_only_their_own_boleto_and_encomienda(): void
    {
        $cliente = $this->createCliente('cliente');
        $otroCliente = $this->createCliente('otro');

        $ruta = Ruta::create([
            'origen' => 'Comarapa',
            'destino' => 'Santa Cruz',
            'distancia_km' => 250,
            'precio_base' => 80,
            'estado_base' => 1,
        ]);
        $bus = Bus::create([
            'placa' => '123ABC',
            'capacidad' => 20,
            'modelo' => 'Mercedes',
            'tipo_bus' => 'Ejecutivo',
            'estado_base' => 1,
        ]);
        $viaje = Viaje::create([
            'ruta_id' => $ruta->id,
            'bus_id' => $bus->id,
            'fecha_viaje' => '2026-12-01',
            'hora_salida' => '08:00',
            'estado' => 'programado',
            'estado_base' => 1,
        ]);
        $tipoEncomienda = TipoEncomienda::create([
            'nombre' => 'Paquete',
            'precio' => 10,
            'estado_base' => 1,
        ]);

        $boleto = $this->createBoleto($cliente, $viaje, 'Pasajero propio', '1A');
        $otroBoleto = $this->createBoleto($otroCliente, $viaje, 'Pasajero ajeno', '1B');
        $encomienda = $this->createEncomienda($cliente, $viaje, $tipoEncomienda, 'Destinatario propio');
        $otraEncomienda = $this->createEncomienda($otroCliente, $viaje, $tipoEncomienda, 'Destinatario ajeno');

        $this->actingAs($cliente, 'cliente')
            ->get(route('cliente.boletos.show', $boleto))
            ->assertOk()
            ->assertSee('Pasajero propio');

        $this->actingAs($cliente, 'cliente')
            ->get(route('cliente.boletos.qr', $boleto->reserva))
            ->assertOk()
            ->assertSee(asset('images/qr.png'), false);

        $this->actingAs($cliente, 'cliente')
            ->get(route('cliente.boletos.show', $otroBoleto))
            ->assertNotFound();

        $this->actingAs($cliente, 'cliente')
            ->get(route('cliente.encomiendas.show', $encomienda))
            ->assertOk()
            ->assertSee('Destinatario propio');

        $this->actingAs($cliente, 'cliente')
            ->get(route('cliente.encomiendas.show', $otraEncomienda))
            ->assertNotFound();
    }

    private function createCliente(string $prefix): Cliente
    {
        return Cliente::create([
            'nombre' => ucfirst($prefix),
            'apellido' => 'Prueba',
            'cedula' => $prefix . '-123',
            'email' => $prefix . '@example.com',
            'contrasena' => bcrypt('password'),
            'estado_base' => 1,
        ]);
    }

    private function createBoleto(Cliente $cliente, Viaje $viaje, string $nombre, string $asiento): Boleto
    {
        $reserva = Reserva::create([
            'cliente_id' => $cliente->id,
            'fecha_reserva' => now(),
            'cantidad' => 1,
            'estado' => 'confirmada',
            'estado_base' => 1,
        ]);

        return Boleto::create([
            'reserva_id' => $reserva->id,
            'viaje_id' => $viaje->id,
            'numero_asiento' => $asiento,
            'nombre_pasajero' => $nombre,
            'precio' => 80,
            'metodo_pago' => 'QR',
            'estado' => 'confirmado',
            'estado_base' => 1,
        ]);
    }

    private function createEncomienda(Cliente $cliente, Viaje $viaje, TipoEncomienda $tipo, string $destinatario): Encomienda
    {
        return Encomienda::create([
            'cliente_id' => $cliente->id,
            'remitente_nombre' => $cliente->nombre_completo,
            'destinatario_nombre' => $destinatario,
            'viaje_id' => $viaje->id,
            'tipo_encomienda_id' => $tipo->id,
            'cantidad' => 1,
            'total_pagar' => 10,
            'estado' => 'recibido',
            'estado_base' => 1,
        ]);
    }
}
