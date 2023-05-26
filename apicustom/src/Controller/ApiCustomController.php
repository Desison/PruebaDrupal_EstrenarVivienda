<?php
/**
 * @file
 * Contains \Drupal\apicustom\Controller\TestAPIController.
 */

namespace Drupal\apicustom\Controller;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
class ApiCustomController extends ControllerBase {


  public function get_api( ) {

    $response['data'] = 'Some test data to return';
    $response['method'] = 'GET';
    $connection = \Drupal::database();
    $query = $connection->query("SELECT * FROM coches");
    $result = $query->fetchAll();
    return new JsonResponse( $result );
  }


  public function put_api( Request $request ) {

    $connection = \Drupal::database();
    $result = $connection->update('coches')
              ->fields([
                'modelo'=> $request->get('modelo'),
                'color' => $request->get('color'),
                'placa' => $request->get('placa')])
              ->condition('nid',$request->get('id'))
              ->execute();
    return new JsonResponse($result);
  }


  public function post_api( Request $request ) {

    $connection = \Drupal::database();
    $result = $connection->insert('coches')
              ->fields(['modelo','color','placa'])
              ->values([
                'modelo'=> $request->get('modelo'),
                'color' => $request->get('color'),
                'placa' => $request->get('placa')])
              ->execute();
    return new JsonResponse( $result );
  }


  public function delete_api( Request $request ) {

    $connection = \Drupal::database();
    $result = $connection->delete('coches')
              ->condition('nid',$request->get('id'))
              ->execute();

    return new JsonResponse( $result );
  }
}
