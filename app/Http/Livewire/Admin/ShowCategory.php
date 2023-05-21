<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;

class ShowCategory extends Component
{
    public $category, $subcategories, $subcategory;
    protected $listeners = ['delete'];



    /* Para conectar con los inputs */
    public $createForm = [

        'name' => null,
        'slug' => null,
        'color' => false,
        'size' => false,
    ];

    /* Para conectar con los inputs */
    public $editForm = [

        'open' => false,
        'name' => null,
        'slug' => null,
        'color' => false,
        'size' => false,
    ];

    /* Validacion */
    protected $rules = [
        'createForm.name' => 'required',
        'createForm.slug' => 'required|unique:subcategories,slug',
        'createForm.color' => 'required',
        'createForm.size' => 'required',
    ];

    /* Cambiar atributos de la validación */

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.slug' => 'slug',
    ];

    /* Funciona para que escuche cuando se cambie el name de la categoria */
    public function updatedCreateFormName($value)
    {
        $this->createForm['slug'] = Str::slug($value);
    }

    /* Funciona para que escuche cuando se cambie el name de la categoria */
    public function updatedEditFormName($value)
    {
        $this->editForm['slug'] = Str::slug($value);
    }

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->getSubcategories();
    }

    public function getSubcategories()
    {
        $this->subcategories = Subcategory::where('category_id', $this->category->id)->get();
    }

    /* Grabar subcategoria */
    public function save()
    {
        $this->validate();
        $this->category->subcategories()->create($this->createForm);
        $this->reset('createForm');
        $this->getSubcategories();
    }

    /* metodo para editar */

    public function edit(Subcategory $subcategory)
    {
        $this->resetValidation();
        $this->subcategory = $subcategory;

        $this->editForm['open'] = true;

        $this->editForm['name'] = $subcategory->name;
        $this->editForm['slug'] = $subcategory->slug;
        $this->editForm['color'] = $subcategory->color;
        $this->editForm['size'] = $subcategory->size;
    }

    /* metodo para actualizar */
    public function update()
    {
        $this->validate([
            'editForm.name' => 'required',
            'editForm.slug' => 'required|unique:subcategories,slug,' . $this->subcategory->id,
            'editForm.color' => 'required',
            'editForm.size' => 'required',
        ]);

        $this->subcategory->update($this->editForm);
        $this->getSubcategories();
        $this->reset('editForm');
    }

    /* metodo para eliminar */

    public function delete(Subcategory $subcategory){
        $subcategory->delete();
        $this->getSubcategories();
    }
    public function render()
    {
        return view('livewire.admin.show-category')->layout('layouts.admin');
    }
}
