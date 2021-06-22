<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function(){
    return view('site/index');
});

/**
 * @OA\Tag(name="encontrar-voos", description="Grupo de recursos para encontrar voos")
 */
Route::group(['prefix'=>'api/v1'], function(){

    /**
     * @OA\Get(
     *     path="/flights",
     *     summary="API que retorna todos os voos disponíveis ordenado em grupo",
     *     tags={"encontrar-voos"},
     *   @OA\Response(
     *      response=200,
     *     description="Resposta do recurso",
     *     @OA\JsonContent(
     *          @OA\Property(
     *              property="flights",
     *              type="object",
     *              @OA\Property(
     *                  property="groups",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="uniqueId",type="integer"),
     *                      @OA\Property(property="totalPrice",type="number", format="float"),
     *                      @OA\Property(
     *                          property="outbound",
     *                          type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer"),
     *                              @OA\Property(property="cia", type="string"),
     *                              @OA\Property(property="fare", type="string"),
     *                              @OA\Property(property="flightNumber", type="string"),
     *                              @OA\Property(property="origin", type="string"),
     *                              @OA\Property(property="destination", type="string"),
     *                              @OA\Property(property="departureDate", type="string", format="date", example="dd/mm/aaaa"),
     *                              @OA\Property(property="arrivalDate", type="string", format="date", example="dd/mm/aaaa"),
     *                              @OA\Property(property="departureTime", type="string", format="hour", example="hh:mm"),
     *                              @OA\Property(property="arrivalTime", type="string", format="hour", example="hh:mm"),
     *                              @OA\Property(property="classService", type="integer"),
     *                              @OA\Property(property="price", type="number", format="float"),
     *                              @OA\Property(property="tax", type="number", format="float"),
     *                              @OA\Property(property="outbound", type="integer", format="float", enum={0,1}),
     *                              @OA\Property(property="inbound", type="integer", format="float", enum={0,1}),
     *                              @OA\Property(property="duration", type="string", format="hour", example="hh:mm")
     *                          )
     *                      ),
     *                 )
     *              )
     *          ),
     *          @OA\Property(property="totalGroups", type="integer"),
     *          @OA\Property(property="totalFlights", type="integer"),
     *          @OA\Property(property="cheapestPrice", type="number", format="float"),
     *          @OA\Property(property="cheapestGroup", type="integer"),
     *     )
     *  )
     * )
     */
    Route::get('flights', 'FlightController@findAllFlights');
});

