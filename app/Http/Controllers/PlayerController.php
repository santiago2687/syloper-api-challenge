<?php

namespace App\Http\Controllers;

use App\Exceptions\PlayerNotFoundException;
use App\Http\Requests\DeletePlayerRequest;
use App\Http\Requests\ProcessTeamRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\TeamResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends Controller
{
    protected PlayerService $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function __invoke(): AnonymousResourceCollection
    {
        $players = Player::all();

        return PlayerResource::collection($players);
    }

    public function store(StorePlayerRequest $request): PlayerResource
    {
        $player = $this->playerService->createPlayer($request->validated());
        return new PlayerResource($player);
    }

    public function show($playerId): PlayerResource
    {
        $player = $this->playerService->findPlayerOrFail($playerId);

        return new PlayerResource($player);
    }

    public function update(UpdatePlayerRequest $request, $playerId): PlayerResource
    {
        $player = $this->playerService->updatePlayer($playerId, $request->validated());

        return new PlayerResource($player);
    }

    public function destroy(DeletePlayerRequest $request, $playerId): JsonResponse
    {
        $this->playerService->deletePlayerOrFail($playerId);

        return response()->json(['message' => 'Player deleted successfully'], 200);
    }

    public function processTeam(ProcessTeamRequest $request): mixed
    {
        try {
            $team = $this->playerService->processTeam($request->validated());

            return TeamResource::collection($team);
        } catch (PlayerNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
