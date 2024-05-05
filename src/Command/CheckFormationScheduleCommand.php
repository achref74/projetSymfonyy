<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

class CheckFormationScheduleCommand extends Command
{
    protected static $defaultName = 'app:check-formation-schedule';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setDescription('Check formations scheduled within 2 days from today');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $twoDaysAhead = (new \DateTime())->modify('+2 days');

        $formations = $this->entityManager
            ->getRepository('App\Entity\Formation')
            ->createQueryBuilder('f')
            ->where('f.datef <= :date')
            ->setParameter('date', $twoDaysAhead->format('Y-m-d'))
            ->getQuery()
            ->getResult();

            $formationNames = [];
        if($formations){
            foreach ($formations as $formation) {
                $formationNames[] = $formation->getNom();
            }
            
            $concatenatedNames = implode(", ", $formationNames);
        // Do something with $formations, like logging or sending notifications.
        $transport = Transport::fromDsn('smtp://api:7f17c1bfd9f26b03acca01e17489f0e7@live.smtp.mailtrap.io:587');

        $mailer = new Mailer($transport);
        //BUNDLE MAILER
        $email = (new Email())
        ->from('mailtrap@demomailtrap.com')
        ->to($user->getEmail())
        ->subject('Mot de passe oublié')
        ->html("<p>Bonjour,</p><p>La formation suivante exipre dans moins de 2 jours,  : <a>$formationNames</a></p>");

        // Send mail
        $mailer->send($email);
    }
        $output->writeln( ' XXXXXXXXXXXXXXXXX---OK----XXXXXXXXXXXXXXXXXXX.');

        return Command::SUCCESS;
    }
}
