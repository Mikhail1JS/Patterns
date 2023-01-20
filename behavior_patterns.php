<?php
//observer

class Finder implements SplObserver
{

    public function __construct(private int $id, private string $name, private string $email, private int $experience)
    {

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getExperience(): int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function update(SplSubject $subject)
    {
        echo "Email-to : {$this->getEmail()} Hello {$this->getName()} ! New offer was add '{$subject->getVacancy()}'. For more information please checkout HandHunter.gb";
    }
}

class HandHunter implements SplSubject
{

    protected string $vacancy = '';

    protected array $storage = [];

    public function attach(SplObserver $observer): void
    {
        $this->storage[$observer->getId()] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        if (isset($this->storage[$observer->getId()])) {
            unset($this->storage[$observer->getId()]);
        }
    }

    public function setVacancy(string $vacancy)
    {
        $this->vacancy = $vacancy;
        $this->notify();
    }

    public function getVacancy(): string
    {
        return $this->vacancy;
    }

    public function notify()
    {
        foreach ($this->storage as $subscriber) {
            $subscriber->update($this);
        }
    }
}

// Strategy

interface IPay
{
    public function pay(int $totalAmount, string $phoneNumber): void;
}

class QiwiPayment implements IPay
{

    private string $client = "Qiwi.url";

    public function pay(int $totalAmount, string $phoneNumber): void
    {
        echo "$this->client send $totalAmount and login by tel : $phoneNumber";
    }
}

class YandexPayment implements IPay
{

    private string $client = "Yandex.url";

    public function pay(int $totalAmount, string $phoneNumber): void
    {
        echo "$this->client send $totalAmount and login by tel : $phoneNumber";
    }
}

class WebMoneyPayment implements IPay
{

    private string $client = "WebMoney.url";

    public function pay(int $totalAmount, string $phoneNumber): void
    {
        echo "$this->client send $totalAmount and login by tel : $phoneNumber";
    }
}

class socksStoreCart
{

    public function __construct(private IPay $payer, private array $user)
    {

    }

    public function checkOut(): void
    {
        $this->payer->pay($this->user['total_amount'], $this->user['phone']);
    }
}

class paymentFactory
{
    public function createPayer(string $payerName): ?IPay
    {
        $className = $payerName . 'Payment';
        if (class_exists($className)) {
            return new $className ();
        }
        return null;
    }
}

$store = new socksStoreCart(( new paymentFactory() )->createPayer('Qiwi'), ['total_amount' => 30000, 'phone' => '+998902349589']);

//command

interface IEditorCommand
{

    public function execute();

}

class CopyText implements IEditorCommand
{

    private string $buffer = '';

    public function __construct(private string $text, private int $startPos, private int $endPos)
    {
    }

    public function execute()
    {
        $this->buffer = mb_substr($this->text, $this->startPos, $this->endPos - $this->startPos);

        return $this->text;
    }

    /**
     * @return string
     */
    public function getBuffer(): string
    {
        return $this->buffer;
    }

}
class CutText implements IEditorCommand
{

    private string $buffer;


    public function __construct(private string $text, private int $startPos, private int $endPos)
    {
    }

    public function execute()
    {

        $this->buffer = mb_substr($this->text, $this->startPos, $this->endPos - $this->startPos);
        $this->text = substr_replace($this->text, '', $this->startPos, $this->endPos - $this->startPos);

        return $this->text;

    }

    public function undo()
    {
        $this->text = substr_replace($this->text, $this->buffer, $this->startPos);
        return $this->text;
    }

    public function getBuffer(): string
    {
        return $this->buffer;
    }
}


class PasteText implements IEditorCommand
{

    public function __construct(private string $text, private string $chapter, private int $startPos, private int $endPos)
    {
    }

    public function execute()
    {

     $this->text = substr_replace($this->text, $this->chapter, $this->startPos );
     return $this->text;

    }

    public function undo()
    {
        $this->text = substr_replace($this->text, '', $this->startPos, mb_strlen($this->chapter));
        return $this->text;
    }


}


class textEditor {
    private array $commands = [];
    private array $logger = [];
    private string $currentText = '';
    private string $buffer = '';

    public function operation (string $operation ,string $text , int $startPos ,int $endPos) {

        if($operation === "copy"){
            $command = new CopyText($text, $startPos , $endPos);
            $this->currentText = $command->execute();
            $this->buffer = $command->getBuffer();
            $this->commands[(new DateTimeImmutable())->format('Y-m-d H:i:s')] = ['type'=>$operation, 'command'=>$command];
        }elseif ($operation === "cut"){
            $command = new CutText($text, $startPos , $endPos);
            $this->currentText = $command->execute();
            $this->buffer = $command->getBuffer();
            $this->commands[(new DateTimeImmutable())->format('Y-m-d H:i:s')] = ['type'=>$operation, 'command'=>$command];
        }elseif ($operation === "paste"){
            $command = new PasteText($text,$this->buffer, $startPos , $endPos);
            $this->currentText = $command->execute();
            $this->commands[(new DateTimeImmutable())->format('Y-m-d H:i:s')] = ['type'=>$operation, 'command'=>$command];
        }


    }

    public function showOperations (){
        print_r($this->commands);
    }

    public function undoOperations ($count){
        for($i = 0 ; $i < $count ; $i++  ){
            $operation = array_pop($this->commands);
            $this->currentText = $operation['command']->undo();
        }
    }


}

