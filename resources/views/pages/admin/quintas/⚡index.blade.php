<?php

use App\Models\Quinta;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Administrar quintas')] class extends Component {
    public ?int $quintaId = null;

    public string $nombre = '';
    public string $slug = '';
    public string $descripcion = '';

    public $capacidad = 16;
    public $habitaciones = 0;
    public $camas = 0;
    public $banos = 0;

    public $precio_fin_semana = 0;
    public $anticipo = null;

    public string $ubicacion = 'Tequesquitengo, Morelos';
    public string $mapa_url = '';

    public string $hora_entrada = '13:00';
    public string $hora_salida = '16:00';

    public bool $publicada = false;
    public bool $destacada = false;

    public $orden = 0;

    #[Computed]
    public function quintas()
    {
        return Quinta::query()
            ->orderByDesc('destacada')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();
    }

    public function updatedNombre(string $nombre): void
    {
        if ($this->quintaId === null) {
            $this->slug = Str::slug($nombre);
        }
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'alpha_dash',
                'max:255',
                Rule::unique('quintas', 'slug')->ignore($this->quintaId),
            ],

            'descripcion' => ['nullable', 'string', 'max:10000'],

            'capacidad' => ['required', 'integer', 'min:1', 'max:100'],
            'habitaciones' => ['required', 'integer', 'min:0', 'max:100'],
            'camas' => ['required', 'integer', 'min:0', 'max:100'],
            'banos' => ['required', 'numeric', 'min:0', 'max:100'],

            'precio_fin_semana' => ['required', 'numeric', 'min:0'],
            'anticipo' => ['nullable', 'numeric', 'min:0'],

            'ubicacion' => ['nullable', 'string', 'max:255'],
            'mapa_url' => ['nullable', 'url', 'max:2048'],

            'hora_entrada' => ['nullable', 'date_format:H:i'],
            'hora_salida' => ['nullable', 'date_format:H:i'],

            'publicada' => ['boolean'],
            'destacada' => ['boolean'],

            'orden' => ['required', 'integer', 'min:0'],
        ];
    }

    public function save(): void
    {
        $this->slug = Str::slug($this->slug ?: $this->nombre);

        $data = $this->validate();

        foreach ([
            'descripcion',
            'anticipo',
            'ubicacion',
            'mapa_url',
            'hora_entrada',
            'hora_salida',
        ] as $campo) {
            if ($data[$campo] === '') {
                $data[$campo] = null;
            }
        }

        if ($this->quintaId !== null) {
            Quinta::findOrFail($this->quintaId)->update($data);
            $mensaje = 'La quinta se actualizó correctamente.';
        } else {
            Quinta::create($data);
            $mensaje = 'La quinta se registró correctamente.';
        }

        $this->resetForm();

        unset($this->quintas);

        session()->flash('status', $mensaje);
    }

    public function edit(int $id): void
    {
        $quinta = Quinta::findOrFail($id);

        $this->quintaId = $quinta->id;

        $this->nombre = $quinta->nombre;
        $this->slug = $quinta->slug;
        $this->descripcion = $quinta->descripcion ?? '';

        $this->capacidad = $quinta->capacidad;
        $this->habitaciones = $quinta->habitaciones;
        $this->camas = $quinta->camas;
        $this->banos = $quinta->banos;

        $this->precio_fin_semana = $quinta->precio_fin_semana;
        $this->anticipo = $quinta->anticipo;

        $this->ubicacion = $quinta->ubicacion ?? '';
        $this->mapa_url = $quinta->mapa_url ?? '';

        $this->hora_entrada = $quinta->hora_entrada
            ? substr((string) $quinta->hora_entrada, 0, 5)
            : '';

        $this->hora_salida = $quinta->hora_salida
            ? substr((string) $quinta->hora_salida, 0, 5)
            : '';

        $this->publicada = $quinta->publicada;
        $this->destacada = $quinta->destacada;
        $this->orden = $quinta->orden;

        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Quinta::findOrFail($id)->delete();

        if ($this->quintaId === $id) {
            $this->resetForm();
        }

        unset($this->quintas);

        session()->flash('status', 'La quinta se eliminó correctamente.');
    }

    private function resetForm(): void
    {
        $this->reset([
            'quintaId',
            'nombre',
            'slug',
            'descripcion',
            'capacidad',
            'habitaciones',
            'camas',
            'banos',
            'precio_fin_semana',
            'anticipo',
            'ubicacion',
            'mapa_url',
            'hora_entrada',
            'hora_salida',
            'publicada',
            'destacada',
            'orden',
        ]);

        $this->capacidad = 16;
        $this->ubicacion = 'Tequesquitengo, Morelos';
        $this->hora_entrada = '13:00';
        $this->hora_salida = '16:00';

        $this->resetValidation();
    }
};

?>

<div class="mx-auto max-w-7xl space-y-8 p-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
            Administración de quintas
        </h1>

        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
            Registra, edita y controla qué propiedades aparecen en el catálogo.
        </p>
    </div>

    @if (session('status'))
        <div class="rounded-lg border border-green-300 bg-green-50 p-4 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <form
        wire:submit="save"
        class="space-y-6 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900"
    >
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                {{ $quintaId ? 'Editar quinta' : 'Registrar quinta' }}
            </h2>

            @if ($quintaId)
                <button
                    type="button"
                    wire:click="cancelEdit"
                    class="rounded-lg border px-4 py-2 text-sm"
                >
                    Cancelar edición
                </button>
            @endif
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <label class="space-y-1">
                <span class="text-sm font-medium">Nombre</span>

                <input
                    type="text"
                    wire:model.live.debounce.300ms="nombre"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"
                >

                @error('nombre')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Dirección amigable (slug)</span>

                <input
                    type="text"
                    wire:model="slug"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"
                >

                @error('slug')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <label class="block space-y-1">
            <span class="text-sm font-medium">Descripción</span>

            <textarea
                wire:model="descripcion"
                rows="4"
                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"
            ></textarea>

            @error('descripcion')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <label class="space-y-1">
                <span class="text-sm font-medium">Capacidad</span>
                <input type="number" min="1" wire:model="capacidad"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('capacidad') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Habitaciones</span>
                <input type="number" min="0" wire:model="habitaciones"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('habitaciones') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Camas</span>
                <input type="number" min="0" wire:model="camas"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('camas') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Baños</span>
                <input type="number" min="0" step="0.5" wire:model="banos"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('banos') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <label class="space-y-1">
                <span class="text-sm font-medium">Precio de fin de semana</span>
                <input type="number" min="0" step="0.01" wire:model="precio_fin_semana"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('precio_fin_semana') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Anticipo</span>
                <input type="number" min="0" step="0.01" wire:model="anticipo"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('anticipo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <label class="space-y-1">
                <span class="text-sm font-medium">Ubicación</span>
                <input type="text" wire:model="ubicacion"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('ubicacion') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Enlace de Google Maps</span>
                <input type="url" wire:model="mapa_url"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('mapa_url') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="grid gap-5 sm:grid-cols-3">
            <label class="space-y-1">
                <span class="text-sm font-medium">Hora de entrada</span>
                <input type="time" wire:model="hora_entrada"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('hora_entrada') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Hora de salida</span>
                <input type="time" wire:model="hora_salida"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('hora_salida') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium">Orden</span>
                <input type="number" min="0" wire:model="orden"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                @error('orden') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="flex flex-wrap gap-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model="publicada">
                <span>Publicada en el catálogo</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model="destacada">
                <span>Propiedad destacada</span>
            </label>
        </div>

        <button
            type="submit"
            class="rounded-lg bg-zinc-900 px-5 py-3 font-semibold text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-900"
        >
            {{ $quintaId ? 'Actualizar quinta' : 'Guardar quinta' }}
        </button>
    </form>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Propiedades registradas</h2>

        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left">Quinta</th>
                        <th class="px-4 py-3 text-left">Capacidad</th>
                        <th class="px-4 py-3 text-left">Precio</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                    @forelse ($this->quintas as $quinta)
                        <tr wire:key="quinta-{{ $quinta->id }}">
                            <td class="px-4 py-4">
                                <div class="font-semibold">{{ $quinta->nombre }}</div>
                                <div class="text-sm text-zinc-500">{{ $quinta->slug }}</div>
                            </td>

                            <td class="px-4 py-4">
                                {{ $quinta->capacidad }} personas
                            </td>

                            <td class="px-4 py-4">
                                ${{ number_format((float) $quinta->precio_fin_semana, 2) }}
                            </td>

                            <td class="px-4 py-4">
                                @if ($quinta->publicada)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-800">
                                        Publicada
                                    </span>
                                @else
                                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-sm text-zinc-700">
                                        Oculta
                                    </span>
                                @endif
                            </td>

                            <td class="space-x-2 px-4 py-4 text-right">
                                <button
                                    type="button"
                                    wire:click="edit({{ $quinta->id }})"
                                    class="rounded-lg border px-3 py-2 text-sm"
                                >
                                    Editar
                                </button>

                                <button
                                    type="button"
                                    wire:click="delete({{ $quinta->id }})"
                                    wire:confirm="¿Seguro que deseas eliminar esta quinta?"
                                    class="rounded-lg bg-red-600 px-3 py-2 text-sm text-white"
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-zinc-500">
                                Todavía no hay propiedades registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>