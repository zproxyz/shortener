<?php

namespace app\controllers;

use shortener\forms\CreateUrlForm;
use shortener\readModels\LinkReadRepository;
use shortener\readModels\LinkStatsReadRepository;
use shortener\repositories\NotFoundException;
use shortener\services\ShortenerService;
use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class LinkController extends Controller
{
    private $shortenerService;
    private $linkReadRepository;
    private $linkStatsReadRepository;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function __construct(
        string $id,
        Module $module,
        ShortenerService $shortenerService,
        LinkReadRepository $linkReadRepository,
        LinkStatsReadRepository $linkStatsReadRepository,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->shortenerService = $shortenerService;
        $this->linkReadRepository = $linkReadRepository;
        $this->linkStatsReadRepository = $linkStatsReadRepository;
    }


    /**
     * @return string|Response
     */
    public function actionList()
    {
        $dataProvider = $this->linkReadRepository->getAll();

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionView(int $id)
    {
        if (($link = $this->linkReadRepository->find($id)) === null) {
            throw new NotFoundException('Link is not found.');
        }

        $dataProvider = $this->linkStatsReadRepository->getAll($link);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        if (($link = $this->linkReadRepository->find($id)) === null) {
            throw new NotFoundException('Link is not found.');
        }

        $this->shortenerService->deleteUrl($link);

        return $this->redirect('list');
    }

    /**
     * @param $id
     *
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        if (($link = $this->linkReadRepository->find($id)) === null) {
            throw new NotFoundException('Link is not found.');
        }

        $link->expiration = $link->expiration ? Yii::$app->formatter->asDatetime($link->expiration,'dd.MM.Y H:mm'): null;
        if ($link->load(Yii::$app->request->post()) &&
            $this->shortenerService->updateExpirationTimeUrl($link)) {
            return $this->redirect(['list']);
        }
        return $this->render('update', [
            'model' => $link,
        ]);
    }

    /**
     * @param string $hash
     *
     * @throws \Exception
     */
    public function actionVisit(string $hash)
    {
        if (($link = $this->linkReadRepository->getByHash($hash)) === null) {
            throw new NotFoundException('Link is not found.');
        }

        $this->shortenerService->visitUrl($link,
            Yii::$app->request->userIP,
            Yii::$app->request->userAgent);


        $this->redirect($link->url);
    }

    /**
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $form = new CreateUrlForm();

        if (!$form->load(Yii::$app->request->post()) || !$form->validate()) {
            return $this->render('create', ['model' => $form]);
        }

        try {
            $this->shortenerService->createShortUrl($form);
        } catch (\Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        return $this->redirect(['list']);
    }

}
