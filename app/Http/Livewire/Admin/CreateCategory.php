<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class CreateCategory extends Component
{
    use WithFileUploads;
    public $brands, $rand;
    public $categories, $category;
    protected $listeners = ['delete'];

    /* Para conectar con los inputs */
    public $editForm = [
        'open' => false,
        'name' => null,
        'slug' => null,
        'icon' => null,
        'image' => null,
        'brands' => [],
    ];

    public $editImage;

    /* Para conectar con los inputs */
    public $createForm = [

        'name' => null,
        'slug' => null,
        'icon' => null,
        'image' => null,
        'brands' => [],
    ];

    /* Validacion */
    protected $rules = [
        'createForm.name' => 'required',
        'createForm.slug' => 'required|unique:categories,slug',
        'createForm.icon' => 'required',
        'createForm.image' => 'required|image|max:1024',
        'createForm.brands' => 'required',
    ];

    /* Cambiar atributos de la validación */

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.slug' => 'slug',
        'createForm.icon' => 'icon',
        'createForm.image' => 'imagen',
        'createForm.brands' => 'marcas',
        'editForm.name' => 'nombre',
        'editForm.slug' => 'slug',
        'editForm.icon' => 'icon',
        'editImage' => 'imagen',
        'editForm.brands' => 'marcas',

    ];

  

    public function mount()
    {
        $this->getCategories();

        $this->getBrands();
        /* aleatoreio para que se reinicie el input file */
        $this->rand = rand();
    }

    /* Funciona para que escuche cuando se cambie el name de la categoria */
    public function updatedCreateFormName($value)
    {
        $this->createForm['slug'] = Str::slug($value);
    }

    public function updatedEditFormName($value)
    {
        $this->editForm['slug'] = Str::slug($value);
    }

    public function getBrands()
    {
        $this->brands = Brand::all();
    }

    public function getCategories()
    {
        $this->categories = Category::all();
    }
    public function save()
    {

        $this->validate();

        /* subir imagen */
        $image = $this->createForm['image']->store('categories');

        $category = Category::create([
            'name' => $this->createForm['name'],
            'slug' => $this->createForm['slug'],
            'icon' => $this->createForm['icon'],
            'image' => $image
        ]);

        $category->brands()->attach($this->createForm['brands']);
        /* aleatoreio para que se reinicie el input file */
        $this->rand = rand();
        $this->reset('createForm');

        $this->getCategories();
        $this->emit('saved');
    }

    public function edit(Category $category)
    {
        $this->reset(['editImage']);
        $this->resetValidation();
        $this->category = $category;
        $this->editForm['open'] = true;
        $this->editForm['name'] = $category->name;
        $this->editForm['slug'] = $category->slug;
        $this->editForm['icon'] = $category->icon;
        $this->editForm['image'] = $category->image;
        $this->editForm['brands'] = $category->brands->pluck('id');
    }

    /* Actualizar categoria */
    public function update()
    {

        $rules = [
            'editForm.name' => 'required',
            'editForm.slug' => 'required|unique:categories,slug,' . $this->category->id,
            'editForm.icon' => 'required',
            'editForm.brands' => 'required',
        ];
        if ($this->editImage) {
            $rules['editImage'] = 'required|image|max:1024';
        }

        $this->validate($rules);

        /* Preguntar si hemos escogido una imagen */

        if ($this->editImage) {
            /* Elimina */
            Storage::delete([ $this->editForm['image']]);

            /* Sube */
            $this->editForm['image'] = $this->editImage->store('categories');
        }
            /* Actualizar todo menos marcas*/
            $this->category->update($this->editForm);
            
            /*Actualizar marcas*/
            $this->category->brands()->sync($this->editForm['brands']);

            $this->reset(['editForm', 'editImage']);

            $this->getCategories();

        
    }


    public function delete(Category $category)
    {
        $category->delete();
        $this->getCategories();
    }
    public function render()
    {
        return view('livewire.admin.create-category');
    }
}
