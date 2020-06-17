// <?php

// namespace App\Models;


// /**
//  * @author Bourne
//  *
//  */
// class BoardInfoDTO {
    
//     /**
//      * @var \App\Models\Project
//      */
//     public $project;
    
//     /**
//      * @var @param \Illuminate\Database\Eloquent\Collection
//      */
//     public $flowProcessCollection;
    
//     /**
//      * @param \App\Models\Project $project
//      * @param \Illuminate\Database\Eloquent\Collection $flowProcessCollection
//      */
//     public function __construct( $project, $flowProcessCollection ){
//         $this->project = $project;
        
//         $this->sortAndAssign( $flowProcessCollection );
        
//     }
    
//     /**
//      * @param \Illuminate\Database\Eloquent\Collection $flowProcessCollection
//      */
//     public function sortAndAssign( $flowProcessCollection ){
        
//         $flowProcessCollection = $flowProcessCollection->sortBy( function ( $value, $key ){
//             return $value->sort_num;
//         } );
        
//         $this->flowProcessCollection = $flowProcessCollection;
        
//         //
//         $flowProcessCollection = $flowProcessCollection->each( function( $value, $key ){
//             $taskCollection = $value->tasks()->sortBy( function ( $v, $k ){
//                 return $v->sort_num;
//             }
//             $value->tasks = $taskCollection;
//         } );
        
        
        
//     }
    
    
    
    
    
    
// }
