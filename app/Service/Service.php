<?php

namespace App\Service;

use Exception;

class Service
{
  protected $model;

  public function delete_records($ids)
  {
    try {
      $this->model::whereIn('id', $ids)->delete();
    } catch (Exception $e) {
      logger()->error('Error deleting records: ' . $e->getMessage());
      return response()->json(['message' => 'Error deleting records. Please try again.'], 500);
    }
  }

  public function __update($id, $data)
  {
    $instance = $this->model::findOrFail($id);
    $instance->fill($data);
    $instance->save();
    return $instance;
  }

  public function __delete($id)
  {

    return $this->model->findOrFail($id)->delete();
  }

  public function getById($id)
  {
    return $this->model::firstOrFail($id);
  }
}
