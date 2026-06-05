<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liste des candidats admis</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            background: #fff;
        }

        .page-header {
            text-align: center;
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: 3px solid #0B3C5D;
        }

        .page-header .kingdom {
            font-size: 11px;
            font-weight: bold;
            color: #333;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .page-header .ministry {
            font-size: 9px;
            color: #555;
            margin-bottom: 8px;
        }

        .page-header .institute-name {
            font-size: 14px;
            font-weight: bold;
            color: #0B3C5D;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .page-header .doc-title {
            font-size: 16px;
            font-weight: bold;
            color: #0B3C5D;
            margin: 10px 0 4px;
            border-top: 1px solid #C4992A;
            border-bottom: 1px solid #C4992A;
            padding: 6px 0;
        }

        .page-header .doc-meta {
            font-size: 9px;
            color: #777;
            margin-top: 4px;
        }

        .page-header .gold-bar {
            height: 3px;
            background: #C4992A;
            margin: 8px auto 0;
            width: 80px;
        }

        .filiere-block {
            margin-bottom: 22px;
            page-break-inside: avoid;
        }

        .filiere-title {
            background: #0B3C5D;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            padding: 7px 12px;
            margin-bottom: 0;
            border-radius: 3px 3px 0 0;
        }

        .filiere-title span {
            color: #C4992A;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        table thead tr {
            background: #1565A9;
        }

        table thead th {
            color: #ffffff;
            padding: 6px 10px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table thead th.center { text-align: center; }

        table tbody tr:nth-child(even) {
            background: #f5f8fc;
        }

        table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        table tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid #e8edf3;
            color: #1a1a1a;
            vertical-align: middle;
        }

        table tbody td.center { text-align: center; }
        table tbody td.num { font-weight: bold; color: #0B3C5D; width: 32px; }
        table tbody td.cin { font-family: monospace; font-weight: bold; color: #333; }
        table tbody td.date { white-space: nowrap; }

        .total-row {
            background: #E8F4FB !important;
            font-weight: bold;
            color: #0B3C5D;
            border-top: 2px solid #1565A9;
        }

        .page-footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #888;
        }

        .stamp-area {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .stamp-box {
            border: 1px solid #ccc;
            padding: 12px 20px;
            text-align: center;
            font-size: 9px;
            color: #555;
            width: 160px;
        }

        .stamp-box .stamp-label {
            font-weight: bold;
            font-size: 10px;
            color: #0B3C5D;
            margin-bottom: 30px;
            display: block;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #888;
            font-style: italic;
            border: 1px dashed #ccc;
            border-radius: 4px;
        }

        .summary-bar {
            background: #f0f4f8;
            border: 1px solid #d0dce8;
            border-radius: 3px;
            padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 9px;
            color: #333;
        }
        .summary-bar strong { color: #0B3C5D; }
    </style>
</head>
<body>

    {{-- ── Institutional Header ─────────────────────────────────────────────── --}}
    <div class="page-header">
        <div class="kingdom">Royaume du Maroc</div>
        <div class="ministry">Ministère de la Pêche Maritime, de l'Aquaculture, de l'Économie Bleue et des Ports</div>
        <div class="institute-name">Centre de Qualification Professionnelle Maritime de Nador</div>
        <div class="gold-bar"></div>
        <div class="doc-title">Liste des candidats admis au concours</div>
        <div class="doc-meta">
            Année : {{ date('Y') }} &nbsp;|&nbsp;
            Édité le : {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }} &nbsp;|&nbsp;
            Total admis : <strong>{{ $accepted->flatten()->count() }}</strong>
        </div>
    </div>

    @if($accepted->isEmpty())
    <div class="empty-state">
        Aucun candidat accepté n'a été trouvé.
    </div>
    @else

    {{-- ── Summary ──────────────────────────────────────────────────────────── --}}
    <div class="summary-bar">
        <strong>Récapitulatif :</strong>
        @foreach($accepted as $filiere => $candidates)
            {{ $filiere }} : <strong>{{ $candidates->count() }}</strong> admis
            @if(!$loop->last) &nbsp;|&nbsp; @endif
        @endforeach
    </div>

    {{-- ── One table per Filière ────────────────────────────────────────────── --}}
    @foreach($accepted as $filiere => $candidates)
    <div class="filiere-block">
        <div class="filiere-title">
            <span>Filière :</span> {{ $filiere }}
            &nbsp;&mdash;&nbsp; {{ $candidates->count() }} candidat{{ $candidates->count() > 1 ? 's' : '' }} admis
        </div>
        <table>
            <thead>
                <tr>
                    <th class="center" style="width:32px">N°</th>
                    <th style="width:45%">Nom et Prénom</th>
                    <th class="center" style="width:20%">Date de naissance</th>
                    <th class="center" style="width:20%">Numéro CIN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidates as $i => $candidate)
                <tr>
                    <td class="num center">{{ $i + 1 }}</td>
                    <td><strong>{{ strtoupper($candidate->nom) }}</strong> {{ $candidate->prenom }}</td>
                    <td class="date center">{{ $candidate->date_naissance->format('d/m/Y') }}</td>
                    <td class="cin center">{{ strtoupper($candidate->cin ?? '—') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="padding: 5px 10px; font-size: 9px;">
                        Total : {{ $candidates->count() }} candidat{{ $candidates->count() > 1 ? 's' : '' }} admis dans cette filière
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach

    {{-- ── Signature / Stamp ────────────────────────────────────────────────── --}}
    <div class="stamp-area">
        <div class="stamp-box">
            <span class="stamp-label">Le Directeur du Centre</span>
            Signature et cachet
        </div>
    </div>

    @endif

    {{-- ── Footer ───────────────────────────────────────────────────────────── --}}
    <div class="page-footer">
        <span>CQPM Nador — Document officiel</span>
        <span>Généré automatiquement le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
    </div>

</body>
</html>
