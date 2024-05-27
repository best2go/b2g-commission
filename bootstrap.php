<?php

declare(strict_types=1);

use Best2Go\Best2GoCommission\CardBinResolver\BinlistCardBinResolver;
use Best2Go\Best2GoCommission\CardBinResolver\CardBinResolver;
use Best2Go\Best2GoCommission\CardBinResolver\CardBinResolverInterface;
use Best2Go\Best2GoCommission\CardBinResolver\FincraCardBinResolver;
use Best2Go\Best2GoCommission\CardBinResolver\RapidapiCardBinResolver;
use Best2Go\Best2GoCommission\CommissionProvider\CommissionProvider;
use Best2Go\Best2GoCommission\CommissionProvider\CommissionProviderInterface;
use Best2Go\Best2GoCommission\FeeCalculator\CeilFeeCalculator;
use Best2Go\Best2GoCommission\FeeCalculator\FeeCalculator;
use Best2Go\Best2GoCommission\FeeCalculator\FeeCalculatorInterface;
use Best2Go\Best2GoCommission\FxRateProvider\ExchangeratesapiFxRateProvider;
use Best2Go\Best2GoCommission\FxRateProvider\FxRateProvider;
use Best2Go\Best2GoCommission\FxRateProvider\FxRateProviderInterface;
use Best2Go\Best2GoCommission\FxRateProvider\PayseraFxRateProvider;
use Best2Go\Best2GoCommission\Transaction\TransactionFactory;
use Best2Go\Best2GoCommission\Transaction\TransactionFactoryInterface;
use Best2Go\Best2GoCommission\Transaction\TransactionProcessor;
use Best2Go\Best2GoCommission\Transaction\TransactionProcessorInterface;
use GuzzleHttp\Client;
use Symfony\Component\Dotenv\Dotenv;

return bootstrap();

/** @deprecated that's where Symfony shiny bright */
function bootstrap(): array
{
    loadEnv();

    $fxRateProvider = createFxRateProvider();
    $cardBinResolver = createCardBinResolver();
    $commissionProvider = createCommissionProvider();
    $feeCalculator = createFeeCalculator();

    $transactionProcessor = createTransactionProcessor(
        $cardBinResolver,
        $fxRateProvider,
        $commissionProvider,
        $feeCalculator
    );

    return [
        FxRateProviderInterface::class => createFxRateProvider(),
        CardBinResolverInterface::class => createCardBinResolver(),
        CommissionProviderInterface::class => createCommissionProvider(),
        TransactionFactoryInterface::class => new TransactionFactory(),
        TransactionProcessorInterface::class => $transactionProcessor,
        FeeCalculatorInterface::class => $feeCalculator,
    ];
}

function createFeeCalculator(): FeeCalculatorInterface
{
    return new CeilFeeCalculator(new FeeCalculator());
}

function loadEnv(): void
{
    $dotEnv = new Dotenv();
    $dotEnv->usePutenv();
    $dotEnv->loadEnv(__DIR__ . '/.env');
}

function createTransactionProcessor(
    CardBinResolverInterface $cardBinResolver,
    FxRateProviderInterface $fxRateProvider,
    CommissionProviderInterface $commissionProvider,
    FeeCalculatorInterface $feeCalculator
): TransactionProcessor {
    return new TransactionProcessor($cardBinResolver, $fxRateProvider, $commissionProvider, $feeCalculator);
}

function createFxRateProvider(): FxRateProviderInterface
{
    $payseraFxRateProvider = new PayseraFxRateProvider(new Client([
        'base_uri' => getenv('PAYSERA_URI'),
    ]));

    $exchangerateapiFxRateProvider = new ExchangeratesapiFxRateProvider(new Client([
        'base_uri' => getenv('EXCHANGERATESAPI_URI'),
        'query' => [
            'access_key' => getenv('EXCHANGERATESAPI_APIKEY'),
        ],
    ]));

    return new FxRateProvider([
        $payseraFxRateProvider,
        $exchangerateapiFxRateProvider,
    ]);
}

function createCardBinResolver(): CardBinResolverInterface
{
    $binlistCardBinResolver = new BinlistCardBinResolver(new Client([
        'base_uri' => getenv('BINLIST_URI'),
    ]));

    $fincraCardBinResolver = new FincraCardBinResolver(new Client([
        'base_uri' => getenv('FINCRA_URI'),
        'headers' => [
            'api-key' => getenv('FINCRA_KEY'),
        ],
    ]));

    $rapidApiCardBinResolver = new RapidapiCardBinResolver(new Client([
        'base_uri' => getenv('RAPIDAPI_URI'),
        'headers' => [
            'X-RapidAPI-Key' => getenv('RAPIDAPI_KEY'),
        ],
    ]));

    return new CardBinResolver([
        $binlistCardBinResolver,
        $fincraCardBinResolver,
        $rapidApiCardBinResolver,
    ]);
}

function createCommissionProvider(): CommissionProviderInterface
{
    return new CommissionProvider();
}
