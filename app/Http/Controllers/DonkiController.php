<?php

namespace App\Http\Controllers;

use App\Services\NasaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonkiController extends Controller
{
    protected $nasaService;

    public function __construct(NasaService $nasaService)
    {
        $this->nasaService = $nasaService;
    }

    /**
     * Procesar datos de DONKI y devolver una respuesta JSON.
     *
     * @param string $key Clave para la respuesta JSON (por ejemplo, "instruments" o "activityIDs").
     * @param callable $processor Función que procesa cada evento.
     * @return JsonResponse
     */
    private function getProcessedData(string $key, callable $processor): JsonResponse
    {
        $data = $this->processDonkiData($processor);
        $data = array_values(array_unique($data));
        return response()->json([$key => $data]);
    }

    /**
     * Procesar datos de DONKI para extraer información específica.
     *
     * @param callable $processor Función que procesa cada evento.
     * @return array
     */
    private function processDonkiData(callable $processor): array
    {
        $endpoints = [
            'CME', 
            'CMEAnalysis', 
            'GST', 
            'IPS', 
            'FLR', 
            'SEP', 
            'MPC', 
            'RBE', 
            'HSS', 
            'WSAEnlilSimulations', 
            'notifications'
        ];

        $results = [];

        foreach ($endpoints as $endpoint) {
            try {
                $data = $this->nasaService->getDonkiData($endpoint);

                foreach ($data as $event) {
                    $results = array_merge($results, $processor($event));
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $results;
    }

    public function getInstruments(): JsonResponse
    {
        return $this->getProcessedData(
            'instruments',
            function ($event) {
                $result = [];
                if (isset($event['instruments'])) {
                    foreach ($event['instruments'] as $instrument) {
                        $result[] = $instrument['displayName'];
                    }
                }
                return $result;
            }
        );
    }

    public function getActivityIDs(): JsonResponse
    {
        return $this->getProcessedData(
            'activityIDs',
            function ($event) {
                $result = [];
                if (isset($event['linkedEvents'])) {
                    foreach ($event['linkedEvents'] as $linkedEvent) {
                        $result[] = $linkedEvent['activityID'];
                    }
                }
                return $result;
            }
        );
    }

    public function getInstrumentUsage(): JsonResponse
    {
        $instrumentCounts = $this->processDonkiData(function ($event) {
            $result = [];
            if (isset($event['instruments'])) {
                foreach ($event['instruments'] as $instrument) {
                    $instrumentName = $instrument['displayName'];
                    if (!isset($result[$instrumentName])) {
                        $result[$instrumentName] = 0;
                    }
                    $result[$instrumentName]++;
                }
            }
            return $result;
        });

        $totalAppearances = array_sum($instrumentCounts);

        $instrumentUsage = [];
        foreach ($instrumentCounts as $instrumentName => $count) {
            $instrumentUsage[$instrumentName] = $count / $totalAppearances;
        }

        return response()->json(['instruments_use' => $instrumentUsage]);
    }

    public function getInstrumentActivityUsage(Request $request): JsonResponse
    {
        $request->validate([
            'instrument' => 'required|string',
        ]);

        $instrumentName = $request->input('instrument');

        $activityCounts = $this->processDonkiData(function ($event) use ($instrumentName) {
            $result = [];
            if (isset($event['instruments']) && in_array($instrumentName, array_column($event['instruments'], 'displayName'))) {
                if (isset($event['linkedEvents'])) {
                    foreach ($event['linkedEvents'] as $linkedEvent) {
                        $activityID = $linkedEvent['activityID'];
                        if (!isset($result[$activityID])) {
                            $result[$activityID] = 0;
                        }
                        $result[$activityID]++;
                    }
                }
            }
            return $result;
        });

        if (empty($activityCounts)) {
            return response()->json([
                'error' => 'No se encontraron actividades para el instrumento.'
            ], 404);
        }

        $totalAppearances = array_sum($activityCounts);

        $instrumentActivityUsage = [];
        foreach ($activityCounts as $activityID => $count) {
            $instrumentActivityUsage[$activityID] = $count / $totalAppearances;
        }

        return response()->json([
            'instrument_activity' => [
                $instrumentName => $instrumentActivityUsage
            ]
        ]);
    }
}