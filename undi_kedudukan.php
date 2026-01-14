<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-biasa.php');

// Ambil senarai calon
$calon = mysqli_query($condb,"SELECT * FROM CALON");
$senarai = [];
while ($row = mysqli_fetch_assoc($calon)) {
    $senarai[] = $row;
}

// Ambil senarai sukan dari pangkalan data
$sukan_query = mysqli_query($condb, "SELECT * FROM sukan");
$sukan =[];
while ($row = mysqli_fetch_assoc($sukan_query)) {
    $sukan[] = $row['nama_sukan'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Borang Undian Kelab Olahraga</title>
    <script>
        function enforceSingleSukanPerCalon() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const selectedSukan = {};

            checkboxes.forEach(checkbox => {
                const calonId = checkbox.name.match(/\[(.*?)\]/)[1];

                if (!selectedSukan[calonId]) {
                    selectedSukan[calonId] = {
                        selected: null,
                        checkboxes: []
                    };
                }

                selectedSukan[calonId].checkboxes.push(checkbox);

                if (checkbox.checked) {
                    selectedSukan[calonId].selected = checkbox.value;
                }
            });

            Object.values(selectedSukan).forEach(calon => {
                calon.checkboxes.forEach(checkbox => {
                    if (calon.selected && checkbox.value !== calon.selected) {
                        checkbox.disabled = true;
                    } else {
                        checkbox.disabled = false;
                    }
                });
            });

            disableDuplicateSelection();
        }

        function disableDuplicateSelection() {
            const selectedValues = {};
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    if (selectedValues[checkbox.value]) {
                        checkbox.checked = false;
                    } else {
                        selectedValues[checkbox.value] = true;
                    }
                }
            });

            checkboxes.forEach(checkbox => {
                if (selectedValues[checkbox.value] && !checkbox.checked) {
                    checkbox.disabled = true;
                }
            });
        }

        function handleCheckboxClick(checkbox) {
            const calonId = checkbox.name.match(/\[(.*?)\]/)[1];
            const calonCheckboxes = document.querySelectorAll(`input[name="undi[${calonId}]"]`);

            calonCheckboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });

            enforceSingleSukanPerCalon();
        }
    </script>
</head>
<body>
    <h2>BORANG UNDIAN SUKAN KELAB OLAHRAGA</h2>

    <form action="proses_undi_kedudukan.php" method="post"
          onchange="enforceSingleSukanPerCalon()">
          |
        <input type="hidden" name="nokp" value="<?=$_SESSION['nokp']?>">

        <?php
        foreach ($senarai as $cl) {
            echo '<div>';
            echo '<img src="'.$cl['gambar'].'" alt="'.$cl['nama_calon'].'" width="150">';
            echo '<p>'.$cl['nama_calon'].'</p>';

            foreach ($sukan as $j) {
                echo '<label>';
                echo '<input type="checkbox" name="undi['.$cl['id_calon'].']" value="'.$j.'"
                        onclick="handleCheckboxClick(this)"> '.$j;
                echo '</label><br>';
            }

            echo '<hr></div>';
        }
        ?>

        <input type="submit" value="SUBMIT">
        </form>
</body>
</html>