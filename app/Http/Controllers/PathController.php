<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\PathRequest;
use App\Models\Coordinate;
use App\Models\InterestPoint;
use App\Models\Path;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;

class PathController extends Controller
{
    use ApiResponser;
    
    public function getAllPaths()
    {
        return $this->success(['paths' => Path::all()],"Percorsi recuperati");
    }

    public function getPath($path)
    {
        try{
            return $this->success(Path::with(['coordinates','interestPoints'])->findOrFail($path),"Percorso recuperato");
        }catch(Exception $e){
            return $this->error("Percorso non trovato",404,$e->getMessage());
        }
    }

    public function getFilteredPaths(FilterRequest $request)
    {
        $filter = $request->validated();

        $paths = new Path();
        if(isset($filter['length'])){
            $paths = $paths->where('length','<=',$filter['length']);
        }
        if(isset($filter['duration'])){
            $paths = $paths->where('duration','<=',$filter['duration']);
        }
        if(isset($filter['disability'])){
            $paths = $paths->where('disability',$filter['disability']);
        }
        if(isset($filter['difficulty'])){
            $paths = $paths->whereIn('difficulty_id',$filter['difficulty']);
        }
        
        $paths = $paths->get();

        return $this->success(['paths' => $paths],"Percorsi recuperati");
    }

    public function addPath(PathRequest $request)
    {
        $data = $request->validated();

        try{
            $newPath = Path::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'difficulty_id' => $data['difficulty_id'],
                'disability' => $data['disability'],
                'length' => $data['length'],
                'duration' => $data['duration'],
                'user_id' => $request->user()->id
            ]);
    
            foreach ($data['coordinates'] as $coordinateSet) {
                Coordinate::create([
                    'latitude' => $coordinateSet['latitude'],
                    'longitude' => $coordinateSet['longitude'],
                    'path_id' => $newPath->id
                ]);
            }
    
            foreach ($data['interest_points'] as $interest_point) {
                InterestPoint::create([
                    'title' => $interest_point['title'],
                    'description' => $interest_point['description'],
                    'category_id' => $interest_point['category_id'],
                    'latitude' => $interest_point['latitude'],
                    'longitude' => $interest_point['longitude'],
                    'path_id' => $newPath->id
                ]);
            }
    
            return $this->success(Path::with(['coordinates','interestPoints'])->findOrFail($newPath->id),"Percorso inserito con successo!");
        }catch (Exception $e) {
            return $this->error("Si è verificato un errore durante il salvataggio!\nRiprovare",404,$e->getMessage());
        }
        
    }

}