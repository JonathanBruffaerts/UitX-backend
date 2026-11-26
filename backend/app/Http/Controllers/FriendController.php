<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function indexUsers(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->select(['id', 'name', 'avatar_url'])
            ->whereKeyNot($request->user()->getKey())
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->paginate(20);

        return response()->json($users);
    }

    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->getKey();

        $friendships = Friendship::query()
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhere('addressee_id', $userId);
            })
            ->with(['requester:id,name,avatar_url', 'addressee:id,name,avatar_url'])
            ->get();

        return response()->json($friendships);
    }

    public function request(Request $request, User $user): JsonResponse
    {
        $requesterId = $request->user()->getKey();

        if ($requesterId === $user->getKey()) {
            return response()->json(['message' => 'Je kunt jezelf geen vriend verzoek sturen.'], 422);
        }

        $existing = Friendship::query()
            ->where(function ($query) use ($requesterId, $user) {
                $query->where(function ($query) use ($requesterId, $user) {
                    $query->where('requester_id', $requesterId)
                        ->where('addressee_id', $user->getKey());
                })->orWhere(function ($query) use ($requesterId, $user) {
                    $query->where('requester_id', $user->getKey())
                        ->where('addressee_id', $requesterId);
                });
            })
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Er bestaat al een vriendschapsverzoek of vriendschap.'], 409);
        }

        $friendship = Friendship::create([
            'requester_id' => $requesterId,
            'addressee_id' => $user->getKey(),
            'status' => 'pending',
        ]);

        return response()->json($friendship, 201);
    }

    public function accept(Request $request, User $user): JsonResponse
    {
        $friendship = Friendship::query()
            ->where('requester_id', $user->getKey())
            ->where('addressee_id', $requesterId = $request->user()->getKey())
            ->where('status', 'pending')
            ->first();

        if (! $friendship) {
            return response()->json(['message' => 'Vriendschapsverzoek niet gevonden.'], 404);
        }

        $friendship->update(['status' => 'accepted']);

        return response()->json($friendship);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        $userId = $request->user()->getKey();

        $deleted = Friendship::query()
            ->where(function ($query) use ($userId, $user) {
                $query->where(function ($query) use ($userId, $user) {
                    $query->where('requester_id', $userId)
                        ->where('addressee_id', $user->getKey());
                })->orWhere(function ($query) use ($userId, $user) {
                    $query->where('requester_id', $user->getKey())
                        ->where('addressee_id', $userId);
                });
            })
            ->delete();

        if (! $deleted) {
            return response()->json(['message' => 'Vriendschap niet gevonden.'], 404);
        }

        return response()->json(['message' => 'Vriendschap verwijderd.']);
    }
}
