<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Banners_m extends MY_Model
{
  public $table = 'site_banner';
  public $table_description = 'site_banner_description';
  public $primary_key = 'id';
  public $foreign_key = 'id_banner';

  public $image_fields = array('id_image', 'id_image_mobile');

  public function get($params = array())
  {
    $options = array(
      'search'    => FALSE,
      'offset'    => FALSE, // A partir de qual row retornar
      'limit'     => FALSE, // Quantidade de rows a retornar
      'order_by'  => FALSE, // Ordenação das colunas
      'count'     => FALSE, // TRUE para trazer apenas a contagem / FALSE para trazer os resultados
      'max'       => FALSE,
      'id'        => FALSE, // Trazer apenas um registro específico pelo id
      'where'     => FALSE, // Array especifico de where
      'slug'      => FALSE,
      'app'       => FALSE, // Requisição vinda do app
    );
    $params = array_merge($options, $params);

    if ($params['search']) {
      if (isset($params['search']['title']) && $params['search']['title'] != '') {
        $this->db->where('(' . $this->table_description . '.title like "%' . $params['search']['title'] . '%")', null, false);
      }
    }

    $toReturn = parent::get($params);

    return $toReturn;
  }

  public function insert($data)
  {
    $this->db->trans_start();

    $insert = array(
      'id_company' => $this->auth->data('company'),
      'order_by' => ($this->get(array('max' => TRUE)) + 1),
      'status' => !empty($data['status']) ? 1 : 0
    );

    $this->insert_single_file($data, $insert);
    $this->db->insert(
      $this->table,
      $insert
    );

    $id = $this->db->insert_id();

    if (!empty($data['value'])) {
      foreach ($data['value'] as $lang => $values) {
        $values                 = array_map(array($this, 'check_null'), $values);
        $array = array(
          $this->foreign_key => $id,
          'id_language' => $lang
        );
        $array = array_merge($array, $values);
        $this->db->insert($this->table_description, $array);
      }
    }

    $this->db->trans_complete();

    return $this->db->trans_status();
  }

  public function update($id, $data)
  {
    $update = array();

    $update['status'] = !empty($data['status']) ? 1 : 0;

    $current = $this->get(array('id' => $id));

    $this->update_single_file($data, $update, $delete_images, $current);

    $this->db->trans_start();
    if (!empty($update)) {
      $this->db->where(array($this->primary_key => $id))
        ->update($this->table, $update);
    }

    foreach ($data['value'] as $lang => $values) {
      $values                 = array_map(array($this, 'check_null'), $values);
      $array = array(
        $this->foreign_key => $id,
        'id_language' => $lang
      );
      $array = array_merge($array, $values);

      $this->db->replace($this->table_description, $array);
    }

    $this->db->trans_complete();

    // Confere se possui imagens cadastradas e deleta caso tudo ocorreu certo
    $this->delete_single_file($delete_images);

    return $this->db->trans_status();
  }
}