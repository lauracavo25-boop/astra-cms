<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Marca;
use App\Models\Contenido;
use App\Models\Formato;
use App\Models\Recurso;
use App\Models\Comentario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba
        $user = User::create([
            'name'     => 'Admin ASTRA',
            'email'    => 'admin@astra.com',
            'password' => Hash::make('password'),
        ]);

        // Marcas de prueba
        $marcas = [
            [
                'nombre'       => 'Nomade Studio',
                'descripcion'  => 'Agencia creativa de diseño y branding',
                'tono'         => 'Moderno, minimalista, profesional',
                'objetivos'    => 'Aumentar reconocimiento de marca y captar clientes premium',
                'pilares'      => 'Diseño, Creatividad, Innovación',
                'buyer_persona'=> 'Emprendedores y empresas medianas que buscan identidad visual',
                'activa'       => true,
            ],
            [
                'nombre'       => 'Verde Vital',
                'descripcion'  => 'Marca de productos naturales y bienestar',
                'tono'         => 'Cercano, natural, inspirador',
                'objetivos'    => 'Educar sobre vida saludable y vender productos orgánicos',
                'pilares'      => 'Salud, Naturaleza, Bienestar',
                'buyer_persona'=> 'Mujeres de 25-45 años interesadas en salud y medio ambiente',
                'activa'       => true,
            ],
            [
                'nombre'       => 'TechFlow AR',
                'descripcion'  => 'Startup de soluciones tecnológicas para PyMEs',
                'tono'         => 'Dinámico, técnico, confiable',
                'objetivos'    => 'Posicionarse como referente tech en Argentina',
                'pilares'      => 'Tecnología, Eficiencia, Confianza',
                'buyer_persona'=> 'Dueños de PyMEs que buscan digitalizar sus procesos',
                'activa'       => true,
            ],
        ];

        $estados = [
            'idea', 'desarrollo', 'aprobado', 'pendiente_grabar',
            'grabado', 'pendiente_edicion', 'editando', 'revision',
            'programado', 'publicado', 'archivado',
        ];

        $tiposFormato = ['reel', 'carrusel', 'historias', 'post'];

        foreach ($marcas as $i => $datosMarca) {
            $marca = Marca::create($datosMarca);
            $prefijo = strtoupper(substr($marca->nombre, 0, 1)) . ($i + 1);

            // 5 contenidos por marca
            for ($j = 1; $j <= 5; $j++) {
                $estado = $estados[array_rand($estados)];
                $fecha  = now()->addDays(rand(-10, 30));

                $contenido = Contenido::create([
                    'marca_id'                  => $marca->id,
                    'codigo'                    => "{$prefijo}-00{$j}",
                    'titulo'                    => "Contenido {$j} de {$marca->nombre}",
                    'objetivo'                  => "Aumentar el engagement y visibilidad de la marca en redes sociales.",
                    'guion'                     => "Introducción llamativa → Desarrollo del tema → CTA final con pregunta para comentarios.",
                    'estado'                    => $estado,
                    'responsable_id'            => $user->id,
                    'fecha_publicacion_prevista' => $fecha,
                ]);

                // 2 formatos por contenido
                foreach (array_slice($tiposFormato, 0, 2) as $tipo) {
                    $formato = Formato::create([
                        'contenido_id' => $contenido->id,
                        'tipo'         => $tipo,
                        'estado'       => $estado,
                        'notas'        => "Formato {$tipo} optimizado para la plataforma principal.",
                    ]);
                }

                // 1 recurso por contenido
                Recurso::create([
                    'contenido_id' => $contenido->id,
                    'tipo'         => 'imagen',
                    'url'          => "https://picsum.photos/seed/{$contenido->codigo}/800/600",
                    'descripcion'  => "Imagen principal del contenido.",
                ]);

                // 1 comentario por contenido
                Comentario::create([
                    'contenido_id' => $contenido->id,
                    'user_id'      => $user->id,
                    'texto'        => "Revisado y listo para continuar con el flujo de producción.",
                ]);
            }
        }
    }
}
