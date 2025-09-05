<?php
$conn = mysqli_connect("localhost", "root", "", "ajxcrud");
$sql = "SELECT * FROM testing";
// $sql = "SELECT * FROM `kumar` ORDER BY address DESC";
//$sql = "SELECT address,phone FROM kumar";

//$sql = "SELECT sum(id),phone FROM kumar GROUP BY phone ORDER BY PHONE ASC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['firstname']; ?></td>
            <td><?php echo $row['lastname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><button type="button" class="btn-delete" data-id="<?php echo $row['id']; ?>">Delete</button></td>
            <td><button type="button" class="btn-edit" data-id="<?php echo $row['id']; ?>">Update</button></td>
        </tr>
<?php
    }
} else {
    echo "0 results";
}
mysqli_close($conn);
?>