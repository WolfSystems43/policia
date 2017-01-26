<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;

class UserCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\User");
        $this->crud->setRoute("admin/user");
        $this->crud->setEntityNameStrings('user', 'users');
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        //$this->crud->setFromDb();

        $this->crud->addField([
            'name' => 'name',
            'label' => "Nombre"
            ]);
        $this->crud->addField([
            'name' => 'steamid',
            'label' => "SteamID"
            ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => "Correo electrónico",
            ]);
        $this->crud->addField([
            'name' => 'profile',
            'label' => "Perfil del foro",
            'type' => 'url'
            ]);
        $this->crud->addField([
            'name' => 'corp',
            'label' => "Cuerpo"
            ]);
        $this->crud->addField([
            'name'        => 'corp', // the name of the db column
            'label'       => 'Cuerpo', // the input label
            'type'        => 'radio',
            'options'     => [ // the key will be stored in the db, the value will be shown as label; 
                                0 => "Sin cuerpo (a elegir)",
                                1 => "Cuerpo Nacional de Policía",
                                2 => "Guardia Civil",
                                3 => "Invisible",
                            ],
            // optional
            //'inline'      => false, // show the radios all on the same line?
        ]);
        $this->crud->addField([
            'name'        => 'rank', // the name of the db column
            'label'       => 'Rango', // the input label
            'type'        => 'radio',
            'options'     => [ // the key will be stored in the db, the value will be shown as label; 
                                0 => "Civil (sin rango)",
                                1 => "Recluta/Cadete (Novato)",
                                2 => "Agente/Guardia Civil",
                                3 => "Agente de Segunda/Guardia Civil de 2ª",
                                4 => "Agente de Primera Clase/Guardia Civil de 1ª Clase",
                                5 => "Suboficial/Cabo",
                                6 => "Oficial en Prácticas/Sargento",
                                7 => "Oficial/Teniente",
                                8 => "Subinspector/Capitán",
                                9 => "Inspector/Comandante (Mando)",
                                10 => "Inspector Jefe/Teniente Coronel (Mando)",
                                11 => "Comisario/Coronel (Mando)",
                                12 => "Comisario Principal (Mando)"
                            ],
            // optional
            //'inline'      => false, // show the radios all on the same line?
        ]);
        $this->crud->addField([
            'name' => 'shop',
            'label' => "Nivel de tienda"
            ]);
        $this->crud->addField([
            'name' => 'shop_reason',
            'label' => "Motivo especial nivel de tienda"
            ]);
        $this->crud->addField(
        [       // SelectMultiple = n-n relationship (with pivot table)
            'label' => "Especialidades",
            'type' => 'select2_multiple',
            'name' => 'specialties', // the method that defines the relationship in your Model
            'entity' => 'specialty', // the method that defines the relationship in your Model
            'attribute' => 'acronym', // foreign key attribute that is shown to user
            'model' => "App\Specialty", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField(
        [   // Checkbox
            'name' => 'disabled',
            'label' => 'Cuenta desactivada',
            'type' => 'checkbox'
        ]);

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');



        // ------ CRUD COLUMNS
        $this->crud->addColumn([
           'name' => 'name', // The db column name
           'label' => "Nombre" // Table column heading
        ]);

        $this->crud->addColumn([
            'name'        => 'corp',
            'label'       => 'Cuerpo',
            'type'        => 'radio',
            'options'     => [ // the key will be stored in the db, the value will be shown as label; 
                                0 => "Sin cuerpo (a elegir)",
                                1 => "Cuerpo Nacional de Policía",
                                2 => "Guardia Civil",
                                3 => "Invisible",
                            ]
        ]);

        $this->crud->addColumn([
            'name'        => 'rank',
            'label'       => 'Rango',
            'type'        => 'radio',
            'options'     => [ // the key will be stored in the db, the value will be shown as label; 
                                0 => "Civil (sin rango)",
                                1 => "Recluta/Cadete (Novato)",
                                2 => "Agente/Guardia Civil",
                                3 => "Agente de Segunda/Guardia Civil de 2ª",
                                4 => "Agente de Primera Clase/Guardia Civil de 1ª Clase",
                                5 => "Suboficial/Cabo",
                                6 => "Oficial en Prácticas/Sargento",
                                7 => "Oficial/Teniente",
                                8 => "Subinspector/Capitán",
                                9 => "Inspector/Comandante (Mando)",
                                10 => "Inspector Jefe/Teniente Coronel (Mando)",
                                11 => "Comisario/Coronel (Mando)",
                                12 => "Comisario Principal (Mando)"
                            ]
        ]);

        $this->crud->addColumn([
           // n-n relationship (with pivot table)
           'label' => "Especialidades", // Table column heading
           'type' => "select_multiple",
           'name' => 'specialty', // the method that defines the relationship in your Model
           'entity' => 'specialties', // the method that defines the relationship in your Model
           'attribute' => "acronym", // foreign key attribute that is shown to user
           'model' => "App\Specialty", // foreign key model
        ]);

        $this->crud->addColumn([
           'name' => 'shop', // The db column name
           'label' => "Nivel de tienda" // Table column heading
        ]);
        
        $this->crud->addColumn([
           'name' => 'active_at', // The db column name
           'label' => "Último login" // Table column heading
        ]);



        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        $this->crud->denyAccess(['delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        $this->crud->allowAccess('revisions');
        $this->crud->with('revisionHistory');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();

        $this->crud->addFilter([ // dropdown filter
          'name' => 'corp',
          'type' => 'dropdown',
          'label'=> 'Cuerpo'
        ], [
          0 => 'Sin cuerpo',
          1 => 'Cuerpo Nacional de Policía',
          2 => 'Guardia Civil',
        ], function($value) { // if the filter is active
            $this->crud->addClause('where', 'corp', $value);
        });
        $this->crud->addFilter([ // add a "simple" filter called Published 
          'type' => 'simple',
          'name' => 'disabled',
          'label'=> 'Desactivados'
        ], 
        false,
        function() { // if the filter is active (the GET parameter "published" exits)
            $this->crud->addClause('where', 'disabled', 1);
        });
        $this->crud->addFilter([ // add a "simple" filter called Published 
          'type' => 'simple',
          'name' => 'not_disabled',
          'label'=> 'Activos'
        ], 
        false,
        function() { // if the filter is active (the GET parameter "published" exits)
            $this->crud->addClause('where', 'disabled', 0);
        });


    }

	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
