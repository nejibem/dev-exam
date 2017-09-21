<?php

namespace CatchOfTheDay\DevExamBundle\Controller;

use CatchOfTheDay\DevExamBundle\Model\TodoListItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        return [
            'items' => $items,
        ];
    }

    /**
     * @Route("/add", name="add")
     * @Method("POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(Request $request)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        if(!$request->get('todo_text'))
        {
            return new JsonResponse(['msg' => 'Failure - Todo can not be blank!'], Response::HTTP_BAD_REQUEST);
        }

        $text = $request->get('todo_text');
        $todo = new TodoListItem();
        $todo->setText($text);

        $items[] = $todo;
        $manager->write($items);

        return new JsonResponse([
            'msg' => 'Successfully added Todo!',
            'todo' => $todo->toAssocArray(),
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/items/{itemId}", name="edit")
     * @Method("PUT")
     *
     * @param Request $request
     * @param string $itemId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editAction(Request $request, $itemId)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        if(!$request->get('todo_text'))
        {
            return new JsonResponse(['msg' => 'Failure - Todo can not be blank!'], Response::HTTP_BAD_REQUEST);
        }

        $text = $request->get('todo_text');
        foreach ($items as $item)
        {
            if($item->getId() === $itemId)
            {
                $item->setText($text);
                break;
            }
        }

        $manager->write($items);

        return new JsonResponse([
            'msg' => 'Successfully added Todo!',
            'todo' => $item->toAssocArray(),
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/items/{itemId}/mark-as-complete", name="mark_as_complete")
     * @Method("POST")
     *
     * @param Request $request
     * @param string $itemId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function markAsCompleteAction(Request $request, $itemId)
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        foreach ($items as $item)
        {
            if($item->getId() === $itemId)
            {
                $item->setComplete(!$item->getComplete());
            }
        }
        $manager->write($items);

        return new JsonResponse([
            'msg' => 'Successfully updated Todo!',
            'todo' => $item->toAssocArray(),
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/list", name="list")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listAction()
    {
        $manager = $this->get('catch_of_the_day_dev_exam.manager.todo_list');
        $items = $manager->read();

        $list = [];
        foreach ($items as $item)
        {
            $list[] = $item->toAssocArray();
        }

        return new JsonResponse($list);
    }

}
