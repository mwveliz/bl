<?php

namespace BL\SGIBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * ExtLogEntries
 */
class ExtLogEntriesRepository extends EntityRepository
{  
    public function bitacora($usuario, $action, $object_class, $object_id) {
             
            $em = $this->getEntityManager();
            $result = $em->createQueryBuilder();            
            
            $qb = $result->select('e')
                        ->from( 'SGIBundle:LogActivity','e')
                        ->where('e.objectId = :object_id')
                        ->setParameter('object_id', $object_id)
                        ->andWhere('e.objectClass LIKE :object_class')
                        ->setParameter('object_class', '%'.$object_class.'%')                            
                        ->orderBy('e.id', 'DESC')
                        ->setMaxResults(1);
                    
            $query = $qb->getQuery()->getResult();
                        
            $ext_log_entries = new LogActivity();
            $ext_log_entries->setAction($action);
            $ext_log_entries->setObjectId($object_id);
            $ext_log_entries->setLoggedAt(new \DateTime("now"));
            $ext_log_entries->setObjectClass($object_class);
//            $ext_log_entries->setVersion($version);
//            $ext_log_entries->setData($arreglo_formulario);
            $Usuario = $em->getReference('BL\SGIBundle\Entity\Usuario', $usuario);
            $ext_log_entries->setUserid($Usuario);
       
            $em = $this->getEntityManager();
            $em->persist($ext_log_entries);
            $em->flush();   
            
            return true;
    }
            
            
}

